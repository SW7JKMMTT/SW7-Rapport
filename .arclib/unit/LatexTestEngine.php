<?php

/**
 * Basic test engine for running tests using Maven.
 */
final class LatexTestEngine extends ArcanistUnitTestEngine {

	private $project_root;

	public function supportsRunAllTests() {
		return true;
	}

	public function run() {
		$working_copy = $this->getWorkingCopy();
		$this->project_root = $working_copy->getProjectRoot();

		$start = microtime(true);

		//Remake bibtex
		list($stdout, $stderr) = execx("make clean bibtex.bib");

		//Hardcode main
		$shit = "main";

		list($err, $stdout, $stderr) = exec_manual("make test");

		$spent = microtime(true) - $start;

		$res = new ArcanistUnitTestResult();
		$res->setName("Latexmk");
		$res->setDuration($spent);
		if($err) {
			$res->setResult(ArcanistUnitTestResult::RESULT_FAIL);
		} else {
			$res->setResult(ArcanistUnitTestResult::RESULT_PASS);
		}
		return array($res);
	}
}
