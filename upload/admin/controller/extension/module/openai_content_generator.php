<?php
class ControllerExtensionModuleOpenAIContentGenerator extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/openai_content_generator');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_openai_content_generator', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/openai_content_generator', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/openai_content_generator', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_openai_content_generator_status'])) {
            $data['module_openai_content_generator_status'] = $this->request->post['module_openai_content_generator_status'];
        } else {
            $data['module_openai_content_generator_status'] = $this->config->get('module_openai_content_generator_status');
        }

        if (isset($this->request->post['module_openai_content_generator_api_key'])) {
            $data['module_openai_content_generator_api_key'] = $this->request->post['module_openai_content_generator_api_key'];
        } else {
            $data['module_openai_content_generator_api_key'] = $this->config->get('module_openai_content_generator_api_key');
        }

        if (isset($this->request->post['module_openai_content_generator_base_url'])) {
            $data['module_openai_content_generator_base_url'] = $this->request->post['module_openai_content_generator_base_url'];
        } else {
            $data['module_openai_content_generator_base_url'] = $this->config->get('module_openai_content_generator_base_url');
        }

        if (isset($this->request->post['module_openai_content_generator_temperature'])) {
            $data['module_openai_content_generator_temperature'] = $this->request->post['module_openai_content_generator_temperature'];
        } else {
            $data['module_openai_content_generator_temperature'] = $this->config->get('module_openai_content_generator_temperature');
        }

        if (isset($this->request->post['module_openai_content_generator_model'])) {
            $data['module_openai_content_generator_model'] = $this->request->post['module_openai_content_generator_model'];
        } else {
            $data['module_openai_content_generator_model'] = $this->config->get('module_openai_content_generator_model');
        }

        // Add available models to data array
        $data['available_models'] = array(
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            'gpt-4' => 'GPT-4',
            'gemini-1.5-flash-002' => 'Gemini 1.5 Flash 002',
            'gemini-1.5-flash-latest' => 'Gemini 1.5 Flash Latest',
            'gpt-4o-mini' => 'GPT-4o Mini'
        );

        // Prompts
        if (isset($this->request->post['module_openai_content_generator_name_prompt'])) {
            $data['module_openai_content_generator_name_prompt'] = $this->request->post['module_openai_content_generator_name_prompt'];
        } else {
            $data['module_openai_content_generator_name_prompt'] = $this->config->get('module_openai_content_generator_name_prompt');
        }

        if (isset($this->request->post['module_openai_content_generator_title_prompt'])) {
            $data['module_openai_content_generator_title_prompt'] = $this->request->post['module_openai_content_generator_title_prompt'];
        } else {
            $data['module_openai_content_generator_title_prompt'] = $this->config->get('module_openai_content_generator_title_prompt');
        }

        if (isset($this->request->post['module_openai_content_generator_model_prompt'])) {
            $data['module_openai_content_generator_model_prompt'] = $this->request->post['module_openai_content_generator_model_prompt'];
        } else {
            $data['module_openai_content_generator_model_prompt'] = $this->config->get('module_openai_content_generator_model_prompt');
        }

        if (isset($this->request->post['module_openai_content_generator_description_prompt'])) {
            $data['module_openai_content_generator_description_prompt'] = $this->request->post['module_openai_content_generator_description_prompt'];
        } else {
            $data['module_openai_content_generator_description_prompt'] = $this->config->get('module_openai_content_generator_description_prompt');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/openai_content_generator', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/openai_content_generator')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['module_openai_content_generator_api_key'])) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/module/openai_content_generator');
        $this->model_extension_module_openai_content_generator->install();
    }

    public function uninstall() {
        $this->load->model('extension/module/openai_content_generator');
        $this->model_extension_module_openai_content_generator->uninstall();
    }

    public function generateProductContent() {
        $json = array();

        if (!$this->user->hasPermission('modify', 'extension/module/openai_content_generator')) {
            $json['error'] = 'You do not have permission to use this feature';
        } elseif (!isset($this->request->get['product_id'])) {
            $json['error'] = 'Product ID is required';
        } elseif (!isset($this->request->get['field'])) {
            $json['error'] = 'Field type is required';
        } else {
            $this->load->model('extension/module/openai_content_generator');
            $this->load->model('catalog/product');

            $product_id = (int)$this->request->get['product_id'];
            $field = $this->request->get['field'];
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if (!$product_info) {
                $json['error'] = 'Product not found';
            } else {
                $generated_content = '';
                $prompt = '';

                // Get product data for placeholders
                $product_name = $product_info['name'];
                $product_meta_title = $product_info['meta_title'];
                $product_model = $product_info['model'];
                $product_description = $product_info['description'];

                switch ($field) {
                    case 'name':
                        $prompt = $this->config->get('module_openai_content_generator_name_prompt');
                        break;
                    case 'title':
                        $prompt = $this->config->get('module_openai_content_generator_title_prompt');
                        break;
                    case 'model':
                        $prompt = $this->config->get('module_openai_content_generator_model_prompt');
                        break;
                    case 'description':
                        $prompt = $this->config->get('module_openai_content_generator_description_prompt');
                        break;
                    default:
                        $json['error'] = 'Invalid field type specified';
                        break;
                }

                if (empty($json['error'])) {
                    if (empty($prompt)) {
                        $json['error'] = 'Prompt not configured for this field type';
                    } else {
                        // Replace placeholders with actual values
                        $prompt = str_replace(
                            array(
                                '{p}',      // product name
                                '{pt}',     // product meta title
                                '{pm}',     // product model
                                '{pd}',     // product description
                                '{pn}',     // product name (alternative)
                                '{pname}'   // product name (full)
                            ),
                            array(
                                $product_name,
                                $product_meta_title,
                                $product_model,
                                $product_description,
                                $product_name,
                                $product_name
                            ),
                            $prompt
                        );

                        $generated_content = $this->model_extension_module_openai_content_generator->generateContent($prompt);

                        if ($generated_content) {
                            $json['success'] = true;
                            $json['data'] = array(
                                'field' => $field,
                                'content' => $generated_content
                            );
                        } else {
                            $json['error'] = 'Failed to generate content. Please check your API key and settings.';
                        }
                    }
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
} 