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
	protected $output;

	public function __construct($output = null) {
		$this -> output = $output ? $output : new UTOutput();
	}

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

		$this -> output -> startTestCaseMessage($className);
		foreach ($testMethods as $testMethod) {
			$this -> runTestMethod($className, $testMethod);
		}
		$this -> output -> successTestCase($className);
	}

	public function runTestMethod($className, $testMethod) {
		$reflMethod = new ReflectionMethod($className, $testMethod);
		$this -> output -> startOneTestCaseMessage($className, $testMethod);
		$this -> setup();
		$reflMethod -> invoke($this);
		$this -> tearDown();
		if ($this -> hasError == true) {
			$this -> output -> failedTestCase($className, $testMethod, $this -> errorMessage);
			exit ;
		} else {
			$this -> output -> successOneCase($className, $testMethod);
		}
	}

	/**
	 * @param boolean
	 * @param string
	 */
	public function assertTrue($isSuccess, $message) {
		if ($isSuccess === false) {
			$this -> hasError = true;
			$this -> errorMessage = $message;
		}
	}

	public function assertFalse($isSuccess, $message) {
		$this -> assertTrue($isSuccess !== true, $message);
	}

	public function assertEq($exp, $act, $message) {
		$result = $exp === $act;
		if($result) {
			$this -> assertTrue($exp === $act, $message);
			return;
		}
		
		$expType = gettype($exp) == "object" ? get_class($exp) : gettype($exp);
		$actType = gettype($act) == "object" ? get_class($act) : gettype($act);

		$expVal = is_object($exp) ? 'obj' : $exp;
		$actVal = is_object($act) ? 'obj' : $act;

		$message = $message . " : exp = ($expType)$expVal, act = ($actType)$actVal";

		$this -> assertTrue($result, $message);
	}
	
	public function assertSameType($expObj, $actObj, $message) {
		$expType = gettype($expObj) == "object" ? get_class($expObj) : gettype($expObj);
		$actType = gettype($actObj) == "object" ? get_class($actObj) : gettype($actObj);
		$this->assertEq($expType, $actType, $message);
	}

}

/**
 * テストの各ステータスの表示出力
 *
 * 出力方法を変えたい場合は
 * このクラスと同じインターフェースのクラスを作って
 * TestCaseのコンストラクタに渡してください。
 */
class UTOutput {
	public function startTestCaseMessage($className) {
		echo "## $className ##\n";
	}
	
	public function startOneTestCaseMessage($className, $methodName) {
		echo "  start $className $methodName ";
	}

	public function successOneCase($className, $methodName) {
		echo "-> success\n";
	}

	public function successTestCase($className) {
		echo "$className is All SUCCESS\n";
	}

	public function failedTestCase($className, $methodName, $message) {
		echo "## TEST FAILED ##\n";
		echo "class : $className \n";
		echo "case  : $methodName \n";
		echo "msg   : $message \n";
	}

}
