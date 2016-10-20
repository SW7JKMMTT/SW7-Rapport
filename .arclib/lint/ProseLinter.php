<?php

final class ProseLinter extends ArcanistLinter
{
	public function getInfoName() {
		return 'proselint';
	}

	public function getInfoURI() {
		return '';
	}

	public function getInfoDescription() {
		return pht('Use proselint for processing specified files.');
	}

	public function getLinterName() {
		return 'prose';
	}

	public function getLinterConfigurationName() {
		return 'prose';
	}

	public function getDefaultBinary() {
		return 'proselint';
	}

	public function getInstallInstructions() {
		return pht('Install proselint with `pip install proselint`');
	}

	protected function getDefaultMessageSeverity($code) {
		return ArcanistLintSeverity::SEVERITY_ADVICE;
	}

	protected function canCustomizeLintSeverities() {
		return true;
	}


	final public function checkBinaryConfiguration() {
		$binary = 'proselint';
		if (!Filesystem::binaryExists($binary)) {
			throw new ArcanistMissingLinterException(
				sprintf(
					"%s\n%s",
					pht(
						'Unable to locate binary "%s" to run linter %s. You may need '.
						'to install the binary, or adjust your linter configuration.',
						$binary,
						get_class($this)),
					pht(
						'TO INSTALL: %s',
						$this->getInstallInstructions())));
		}
	}

	public function lintPath($path)
	{
		$absolute_path =  $this->getEngine()->getFilePathOnDisk($path);
		$lint_command = 'proselint --json ' . $absolute_path;

		$final_lint_command = $lint_command;
		list($err, $stdout, $stderr) = exec_manual($final_lint_command);

		$ok = ($err == 0 || $err == 1); // proselint returns 1 if linter warnings were detected.

		if (!$ok) {
			return;
		}

		$results = json_decode($stdout, TRUE);

		$errors = (array)$results['data']['errors'];

		if (empty($errors)) {
			return;
		}

		$messages = array();

		foreach ($errors as $error) {
			$message = id(new ArcanistLintMessage())
				->setPath($absolute_path)
				->setLine($error['line'])
				->setChar($error['column'])
				->setCode($error['check'])
				->setSeverity($this->getLintMessageSeverity($error['check']))
				->setName('proselint violation')
				->setDescription($error['message']);
			$messages []= $message;
		}

		foreach ($messages as $message) {
			$this->addLintMessage($message);
		}
	}
}
