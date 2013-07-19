<?php

/**
 * 簡易テストクラス
 *
 * 使い方
 * - このクラスを継承する
 * - testで始まるメソッド名でメソッドを作成する
 * - runTest()をコールする
 * => テストが実行される。
 * 失敗した場合はエラーメッセージを表示し、テストが停止される。
 */
class TestCase {
	private $hasError = false;
	private $errorMessage;
	private $testMethodNames;

	public function runTest() {
		$this -> runTestMethodsInClass(get_class($this));
	}

	public function getTestCount() {
		return count($this -> getTestMethodNames());
	}

	public function setup() {
	}

	public function tearDown() {
	}

	private function getTestMethodNames() {
		if (!$this -> testMethodNames) {
			$testMethodNames = array();
			$methodNames = get_class_methods(get_class($this));
			foreach ($methodNames as $methodName) {
				if (strpos($methodName, 'test') === 0)
					$this -> testMethodNames[] = $methodName;
			}
		}
		return $this -> testMethodNames;
	}

	private function runTestMethodsInClass() {
		$className = get_class($this);
		$testMethods = $this -> getTestMethodNames();
		
		foreach ($testMethods as $testMethod) {
			$this -> runTestMethod($className, $testMethod);
		}
		
		$this -> success($className);
	}

	public function runTestMethod($className, $testMethod) {
		$reflMethod = new ReflectionMethod($className, $testMethod);
		$this -> startMessage($className, $testMethod);
		$this -> setup();
		$reflMethod -> invoke($this);
		$this -> tearDown();
		if ($this -> hasError == true) {
			$this -> failed($className, $testMethod, $this -> errorMessage);
		} else {
			echo "success\n";
		}
	}

	/**
	 * @param boolean
	 * @param string
	 */
	public function assertEq($isSuccess, $message) {
		if (!$isSuccess) {
			$this -> hasError = true;
			$this -> errorMessage = $message;
		}
	}

	private function startMessage($className, $methodName) {
		echo "$className $methodName ";
	}

	private function failed($className, $methodName, $message) {
		echo "\n## TEST FAILED ##\n";
		echo "class : $className \n";
		echo "case  : $methodName \n";
		echo "msg   : $message \n";
		exit ;
	}

	private function success($className) {
		echo "\nSUCCESS : $className \n";
	}
}
