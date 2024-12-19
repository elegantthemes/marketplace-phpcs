# PHP CodeSniffer for Elegant Themes Marketplace

## Prerequisites

Before using this tool, ensure the following software is installed:

1. **Git** (Distributed version-control system)
   - [Download Git](https://git-scm.com/downloads)

2. **Composer** (PHP Dependency Manager)
   - [Download Composer](https://getcomposer.org/download/)

## Installation and Usage

Follow these steps to set up and use the PHP CodeSniffer ruleset:

### 1. Clone the Repository

Run the following command to clone the repository:
```bash
git clone https://github.com/elegantthemes/marketplace-phpcs/
```

### 2. Install Dependencies

Navigate to the `marketplace-phpcs` directory and run:
```bash
cd marketplace-phpcs
composer install
```

> **Tip:** Ensure Composer is installed and available in your system's PATH. If not, refer to the [Composer Installation Guide](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

### 3. Run PHP CodeSniffer

#### Run PHP CodeSniffer - Display Warning and Errors
Use the following command to scan your product code for issues:
```bash
./vendor/bin/phpcs --standard=ruleset.xml /full/path/to/your/product
```

Example Output:
```
FILE: .../path/to/your/project/file.php
--------------------------------------------------------------------------------
FOUND 5 ISSUES AFFECTING 5 LINES
--------------------------------------------------------------------------------
  32 | ERROR | Missing nonce verification when processing form data.
  45 | ERROR | Data from user input is not sanitized before use.
  58 | WARNING | The function 'processData' is defined but never used.
  72 | WARNING | Variable $temp is assigned a value but never used.
  85 | WARNING | Missing doc comment for function.
--------------------------------------------------------------------------------
```

#### Run PHP CodeSniffer - Display Errors Only

To exclude warnings and show only errors, add the `-n` flag:
```bash
./vendor/bin/phpcs --standard=ruleset.xml /full/path/to/your/product -n
```

Example Output:
```bash
FILE: .../path/to/your/project/file.php
--------------------------------------------------------------------------------
FOUND 4 ERRORS AFFECTING 4 LINES
--------------------------------------------------------------------------------
  32 | ERROR | Missing nonce verification when processing form data.
  45 | ERROR | Data from user input is not sanitized before use.
  58 | ERROR | Missing capability check before performing action.
  72 | ERROR | Data output is not escaped before displaying to user.
--------------------------------------------------------------------------------
```

#### Run PHP CodeSniffer - Display Error Only and Display Error Codes

To display only errors and include error codes for easier debugging, you can combine both the `-n` and `-s` flags:
```bash
./vendor/bin/phpcs --standard=ruleset.xml /full/path/to/your/product -n -s
```

> **Note:** The `-n` flag excludes warnings, showing only errors.
> **Note:** The `-s` flag displays error codes, making it easier to identify and suppress specific issues.

Example Output:
```bash
FILE: .../path/to/your/project/file.php
--------------------------------------------------------------------------------
FOUND 4 ERRORS AFFECTING 4 LINES
--------------------------------------------------------------------------------
  32 | ERROR | Missing nonce verification when processing form data. (WordPress.Security.NonceVerification.Missing)
  45 | ERROR | Data from user input is not sanitized before use. (ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized)
  58 | ERROR | Missing capability check before performing action. (WordPress.Security.CapabilityCheck.Missing)
  72 | ERROR | Data output is not escaped before displaying to user. (WordPress.Security.EscapeOutput.Missing)
--------------------------------------------------------------------------------
```


## Ignoring Specific Errors

Sometimes, you may want to ignore certain errors. Use the following guidelines to suppress them:

### Ignoring a Single Line

- **Before the line:**
  ```php
  // phpcs:ignore Error.Code.Here
  process_data();
  ```
- **Before the line, with a reason:**
  ```php
  // phpcs:ignore Error.Code.Here -- The reason why this is being ignored.
  process_data(); 
  ```


- **At the end of the same line:**
  ```php
  process_data(); // phpcs:ignore Error.Code.Here
  ```

- **At the end of the same line, with a reason:**
  ```php
  process_data(); // phpcs:ignore Error.Code.Here -- The reason why this is being ignored.
  ```



### Ignoring Multiple Lines

Use `phpcs:disable` and `phpcs:enable` to suppress errors for a block of code:
```php
// phpcs:disable Error.Code.Here
process_data();
another_function();
// phpcs:enable Error.Code.Here
```

> **Tip:** Always specify the error code (e.g., `WordPress.Security.NonceVerification.Missing`) to avoid unintentionally suppressing unrelated issues.

## Common Pitfalls

1. **Spacing and Case Sensitivity:**
   - Ensure there’s a space after `//` in comments (e.g., `// phpcs:ignore` not `//phpcs:ignore`).
   - `phpcs` directives are case-sensitive.

2. **Composer Not Found:**
   - If you encounter a "command not found" error for Composer, ensure it’s installed and available in your PATH.

3. **Error Code Mismatch:**
   - Verify the exact error code using the `-s` flag. Typos or incorrect casing will cause `phpcs:ignore` to fail.

4. **Make sure not to ingore everything!:**
   - Don't merely do this: `// phpcs:ignore` (Note the lack of an error code)
   - Always specify the error code (e.g., `WordPress.Security.NonceVerification.Missing`) to avoid unintentionally suppressing unrelated issues.


## FAQ

### 1. **What is PHP CodeSniffer (PHPCS)?**
PHP CodeSniffer is a tool that detects violations of coding standards in PHP files. It ensures your code adheres to best practices and marketplace requirements.

### 2. **What does the `ruleset.xml` file do?**
The `ruleset.xml` file defines the coding standards and rules specific to Elegant Themes. It’s automatically used when you run `phpcs` with this repository.

### 3. **Why am I seeing so many errors and warnings?**
The tool enforces strict coding standards. Most issues are minor (e.g., formatting). To focus only on critical errors, use the `-n` flag.

### 4. **How can I suppress errors I can’t fix?**
Use `phpcs:ignore` comments as described above, but only after ensuring the issue isn’t critical.

### 5. **How do I know which errors to fix?**
Focus on errors flagged as "ERROR" first. Warnings are typically less critical and may relate to formatting or recommendations.

## Need Help?
If you encounter issues, refer to the official [PHP CodeSniffer Documentation](https://github.com/squizlabs/PHP_CodeSniffer/wiki) or contact the Elegant Themes support team for assistance.
