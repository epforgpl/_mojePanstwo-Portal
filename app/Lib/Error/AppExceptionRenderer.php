<?
App::uses( 'ExceptionRenderer', 'Error' );

class AppExceptionRenderer extends ExceptionRenderer {
	public function render() {

		if ( $this->error instanceof MP\ApiConnectionException ) {
			$url  = $this->controller->request->here();
			$code = 500;
			$this->controller->response->statusCode( $code );
			$this->controller->set( array(
				'code'       => $code,
				'url'        => h( $url ),
				'name'       => h( $this->error->getMessage() ),
				'error'      => $this->error,
				'_serialize' => array( 'code', 'url', 'name', 'error' )
			) );
			$this->template = str_replace( 'mP\\', 'mp/', $this->template );
			$this->_outputMessage( $this->template );

		} elseif ( $this->error instanceof MissingControllerException ) {

			if ( is_numeric( $this->controller->request->params['action'] ) ) {

				$url = '/dane' . $this->controller->request->here();
				$this->controller->redirect( $url );

			} else {
				return parent::render();
			}

		} else {

			return parent::render();

		}
	}
}