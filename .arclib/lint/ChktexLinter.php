<?php

final class ChktexLinter extends ArcanistLinter
{
	public function getInfoName()
	{
		return "Chktex";
	}

	public function getLinterConfigurationName()
	{
		return 'chktex';
	}

	public function getLinterConfigurationOptions()
	{

		$options = parent::getLinterConfigurationOptions();

		return $options;
	}

	public function setLinterConfigurationValue($key, $value)
	{
		switch ($key) {
			/* case 'pmd': */
			/*     $this->pmdEnabled = $value; */
			/*     return; */
		}
		parent::setLinterConfigurationValue($key, $value);
	}

	public function getLinterName()
	{
		return 'ChktexLinter';
	}

    public function lintPath($path)
    {
		$lint_command = 'chktex -v0 ' . $path;

		$final_lint_command = $lint_command;
		echo "Linting Project...\n";
		echo "Executing: $final_lint_command \n";
		list($stdout, $stderr) = execx($final_lint_command);

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

				$messages[$message->getPath() . ':' . $message->getLine() . ':' . $message->getChar() . ':' . $message->getName() . ':' . $message->getDescription()] = $message;
			}
		}

		foreach ($messages as $message) {
			$this->addLintMessage($message);
		}
	}
}
