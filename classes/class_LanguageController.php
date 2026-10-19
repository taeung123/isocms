<?php
class LanguageController
{
    /**
     * @var LanguageService
     */
    protected $service;
    /**
     * Request
     */
    protected $request;
    /**
     * Response
     */
    protected $response;
	public function __construct(LanguageService $service = null)
	{
		$this->service = $service ?: new LanguageService();
		$this->request = array_merge($_GET, $_POST);
	}
	public function dispatch()
	{
		try{
			$cmd = $this->request['cmd'] ?? 'load';
			switch ($cmd) {
				case 'load':
					$this->load();
					break;
				case 'save':
					$this->save();
					break;
				case 'audit':
					$this->audit();
					break;
				case 'info':
					$this->info();
					break;
				case 'backup':
					$this->backup();
					break;
				case 'restore':
					$this->restore();
					break;
				case 'saveRow':
					$this->saveRow();
					break;	
				default:
					$this->json([
						'success'=>false,
						'code'=>'INVALID_ACTION'
					]);
			}
		}
		catch(Exception $e){
			$this->json([
				'success'=>false,
				'code'=>'SERVER_ERROR',
				'message'=>$e->getMessage()
			],500);
		}
	}
	protected function validateRequest(array $required)
	{
	}
	protected function json(
		array $response,
		$status = 200
	)
	{
		http_response_code($status);
		header(
			'Content-Type: application/json;charset=utf-8'
		);
		echo json_encode(
			$response,
			JSON_UNESCAPED_UNICODE
		);
		exit;
	}
	protected function load()
	{
		$result = $this->service->load(
			$this->request['group'],
			$this->request['language']
		);
		$this->json($result);
	}
	protected function save()
	{
		$this->verifyCsrf();	
		$changes = json_decode(
			$this->request['changes'],
			true
		);
		$result = $this->service->save(
			$this->request['group'],
			$this->request['language'],
			$changes
		);
		$this->json($result);
	}
	protected function saveRow()
	{
		$this->verifyCsrf();
		$item = json_decode($_POST['item'], true);
		
		/*var_dump($item);
		die();*/
		
		if (!is_array($item)) {
			return $this->json([
				'success' => false,
				'message' => 'Invalid data.'
			]);
		}
		$result = LanguageService::saveRow(
			$_POST['group'],
			$_POST['language'],
			$item
		);
		$this->json($result);
	}
	protected function audit()
	{
	}
	protected function info()
	{
	}
	protected function verifyCsrf()
	{
		if (
			empty($_POST['csrf_token']) ||
			!CsrfHelper::verify($_POST['csrf_token'])
		) {
			$this->json([
				'success'=>false,
				'code'=>'INVALID_CSRF',
				'message'=>'CSRF token không hợp lệ.'
			],403);
		}
	}
}