# OpenAI Content Generator for OpenCart 3

A powerful OpenCart 3 extension that leverages OpenAI's API to automatically generate high-quality product content, enhancing your store's SEO and product descriptions.

## Features

- **Multiple AI Models Support**
  - GPT-3.5 Turbo
  - GPT-4
  - Gemini 1.5 Flash 002
  - Gemini 1.5 Flash Latest
  - GPT-4o Mini

- **Customizable Content Generation**
  - Generate product names
  - Create meta titles
  - Generate product models
  - Write detailed descriptions
  - Customizable prompts for each field

- **Advanced Settings**
  - API key management
  - Custom base URL support
  - Temperature control for content creativity
  - Model selection
  - Placeholder support for dynamic content

![Alt text](img.jpg?raw=true "OpenAI Content Generator for OpenCart 3")

## Installation

1. Download the latest release
2. Upload the contents of the `upload` folder to your OpenCart root directory
3. Go to Admin Panel → Extensions → Extensions
4. Select "Modules" from the dropdown
5. Find "OpenAI Content Generator" and click "Install"
6. Click "Edit" to configure the module

## Configuration

1. **API Settings**
   - Enter your OpenAI API key
   - Set custom base URL if needed
   - Choose your preferred AI model
   - Adjust temperature (0.0 to 1.0)

2. **Prompt Configuration**
   - Customize prompts for each content type
   - Use placeholders for dynamic content:
     - `{p}` - Product name
     - `{pt}` - Product meta title
     - `{pm}` - Product model
     - `{pd}` - Product description
     - `{pn}` - Product name (alternative)
     - `{pname}` - Product name (full)

## Usage

1. Go to Catalog → Products
2. Edit any product
3. Use the "Generate Content" buttons next to each field
4. Review and save the generated content

## Requirements

- OpenCart 3.x
- PHP 7.4 or higher
- cURL extension enabled
- Valid OpenAI API key

## Support

For support, please:
1. Check the [documentation](docs/)
2. Open an [issue](https://github.com/yourusername/openai_content_generator/issues)
3. Contact support@example.com

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Acknowledgments

- OpenAI for their powerful API
- OpenCart community for the platform
- All contributors who help improve this extension

## Changelog

### v1.0.0
- Initial release
- Support for multiple AI models
- Customizable prompts
- Temperature control
- Placeholder system

## Security

Please report any security issues to security@example.com 
