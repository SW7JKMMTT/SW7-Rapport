<?php

final class ChktexLinter extends ArcanistExternalLinter
{
	public function getInfoName()
	{
		return "Chktex";
	}

	public function getLinterConfigurationName()
	{
		return 'chktex';
	}

	public function getInfoDescription()
	{
		return pht('Use Chktex to check your LaTeX');
	}

	public function getDefaultBinary()
	{
		return 'chktex';
	}

	public function getInstallInstructions()
	{
		return pht('Install chktex you fuck');
	}

	public function shouldExpectCommandErrors()
	{
		/* return true; */
	}

	protected function canCustomizeLintSeverities()
	{
		return true;
	}

	public function getLinterName()
	{
		return 'ChktexLinter';
	}

	protected function getMandatoryFlags() {
		return array(
			'-v0'
		);
	}

	protected function parseLinterOutput($path, $err, $stdout, $stderr) {
		$messages = array();
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $stdout) as $line) {
			if(preg_match("/([^:]+):([0-9]+):([0-9]+):([0-9]+):(.*)/", $line, $matches)) {
				list($_, $file, $line, $char, $err, $desc) = $matches;
				$message = new ArcanistLintMessage();
				$message->setName("ChkTex");

				$message->setPath($file);
				$message->setLine($line);
				$message->setChar($char);
				$message->setCode($err);
				$message->setDescription($desc);

				$message->setSeverity(ArcanistLintSeverity::SEVERITY_WARNING);

				$messages[] = $message;
			}
		}
		return  $messages;
	}
}
