<?php

class ApiController extends Controller {

    Const APPLICATION_ID = '4FC13A6C19A59';

    private $format = 'json';
    private $orgaoParaTratar = array(
        'CAMARA MUNICIPAL' => 'CÂMARA MUNICIPAL',
        'ENCARGOS GERAIS DO MUNICIPIO' => 'ENCARGOS GERAIS DO MUNÍCIPIO',
        'GABINETE DE COMUNICACAO SOCIAL' => 'GABINETE DE COMUNICAÇÃO SOCIAL',
        'SECRETARIA DA ADMINISTRACAO' => 'SECRETARIA DA ADMINISTRAÇÃO',
        'SECRETARIA DAS FINANCAS' => 'SECRETARIA DAS FINANÇAS',
        'SECRETARIA DE INFRAESTRUTURA' => 'SECRETARIA DE INFRA-ESTRUTURA',
        'SECRETARIA MUNICIPAL DE  EDUCAÇÃO  E CULTURA' => 'SECRETARIA MUNICIPAL DE EDUCAÇÃO E CULTURA',
        'SECRETARIA MUNICIPAL DE SAUDE' => 'SECRETARIA MUNICIPAL DE SAÚDE',
        'SECRETARIA MUNICIPAL  DO MEIO-AMBIENTE' => 'SECRETARIA MUNICIPAL DO MEIO-AMBIENTE',
    );

    /**
     * @return array action filters
     */
    public function filters() {
        return array();
    }

    public function actionListar() {

        parse_str($_SERVER['QUERY_STRING'], $query);

        $padrao = array(
            'pageSize' => '25',
            'page' => 0,
            'skip' => 0
        );

        $query = array_merge($padrao, $query);

        // Get the respective model instance
        switch ($_GET['model']) {
            case 'receita':
                $criteria = new CDbCriteria();
                $criteria->limit = $query['pageSize'];
                $criteria->offset = $query['skip'];
                $criteria->select = "ano_refe, mes_refe, codi_enti, 
                    nome_enti, codi_rece, desc_rece, desc_forc, to_char(valo_arre, 'L999G999G999D99') as valo_arre, data_ulal, matr_usua  ";
                $criteria->order = 'ano_refe DESC,mes_refe DESC,desc_rece ASC';
                if (isset($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);
                if (isset($query['mes']))
                    $criteria->compare('mes_refe', $query['mes']);
                if (isset($query['entidade']))
                    $criteria->compare('codi_enti', $query['entidade']);

                $models = Receita::model()->findAll($criteria);
                $count = Receita::model()->count();

                $criteria->select = 'SUM(valo_arre) as valo_arre';
                $criteria->limit = $criteria->offset = $criteria->order = '';
                $total = Receita::model()->find($criteria);
                $total = $total->valo_arre;
                break;
            case 'despesa':
                $criteria = new CDbCriteria();
                $criteria->limit = $query['pageSize'];
                $criteria->offset = $query['skip'];
                $criteria->select = "ano_refe, mes_refe, codi_enti, nome_enti,
                    desc_forc, nume_empe,  desc_tpem, desc_orga,
                    nome_forn, desc_desp, desc_orga, desc_tpde, 
                    to_char(valo_empe, 'L999G999G999D99') as valo_empe";
                $criteria->distinct = true;
                $criteria->order = 'ano_refe DESC,mes_refe DESC,nome_forn ASC';
                if (!empty($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);
                if (!empty($query['mes']))
                    $criteria->compare('mes_refe', $query['mes']);
                if (!empty($query['entidade']))
                    $criteria->compare('codi_enti', $query['entidade']);

                if (!empty($query['tipoEmpenho']))
                    $criteria->compare('desc_tpem', $query['tipoEmpenho']);
                if (!empty($query['desc_forc']))
                    $criteria->compare('codi_enti', $query['fonteRecursos']);
                if (!empty($query['numeroEmpenho']))
                    $criteria->compare('nume_empe', $query['numeroEmpenho']);
                if (!empty($query['fornecedor']))
                    $criteria->compare('nome_forn', $query['fornecedor'], true);
                if (!empty($query['orgao'])) {
                    $key = array_search($query['orgao'], $this->orgaoParaTratar);
                    if (!empty($key)) {
                        $criteria->condition = $criteria->condition . " AND desc_orga IN ('{$key}', '{$query['orgao']}')";
                    } else {
                        $criteria->compare('desc_orga', $query['orgao']);
                    }
                }

                $models = Despesa::model()->findAll($criteria);
                $count = Despesa::model()->count();

                //total
                $where = '1=1';
                if (!empty($query['ano']))
                    $where .= " AND ano_refe = {$query['ano']}";
                if (!empty($query['mes']))
                    $where .= " AND mes_refe = {$query['mes']}";
                if (!empty($query['entidade']))
                    $where .= " AND codi_enti = {$query['entidade']}";
                $sql = "
                    SELECT SUM(d.valo_empe) as valo_empe 
                    FROM(
                        SELECT DISTINCT nume_empe, valo_empe 
                        FROM despesa_lei131 
                        WHERE {$where}
                        ) d";

                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $total = $command->queryRow();
                $total = $total['valo_empe'];
                break;
            default:
                $this->_sendResponse(501, sprintf(
                                'Error: Mode <b>list</b> is not implemented for model <b>%s</b>', $_GET['model']));
                Yii::app()->end();
        }

        switch ($_GET['model']) {
            case 'receita':
                $json = array(
                    'data' => $this->modelToArray($models),
                    'count' => $count,
                    'total' => 'R$ ' . number_format($total, 2, ',', '.')
                );
                break;
            case 'despesa':
                $json = array(
                    'data' => $this->modelToArray($models),
                    'count' => $count,
                    'total' => 'R$ ' . number_format($total, 2, ',', '.')
                );
                break;
        }
        $this->_sendResponse(200, CJSON::encode($json), 'application/json');
    }

    public function actionDetalhe() {
        parse_str($_SERVER['QUERY_STRING'], $query);

        switch ($_GET['model']) {
            case 'receita':
                $criteria = new CDbCriteria();
                if (isset($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);
                if (isset($_GET['mes']))
                    $criteria->compare('mes_refe', U::getIndexMes($_GET['mes']));
                if (isset($query['entidade']))
                    $criteria->compare('codi_enti', $query['entidade']);
                if (isset($query['cod_receita']))
                    $criteria->compare('codi_rece', $query['cod_receita']);

                $model = Receita::model()->find($criteria);
                $model = $model->attributes;

                $model['data_ulal'] = U::dataDoBanco($model['data_ulal']);
                $model['valo_arre'] = 'R$ ' . number_format($model['valo_arre'], 2, ',', '.');

                $count = Receita::model()->count($criteria);
                break;
            case 'despesa':
                $criteria = new CDbCriteria();
                if (isset($query['empenho']))
                    $criteria->compare('nume_empe', $query['empenho']);
                if (isset($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);
                if (isset($query['mes']))
                    $criteria->compare('mes_refe', $query['mes']);

                $model = Despesa::model()->find($criteria);
                $model = $model->attributes;

                foreach ($model as $m => $v) {
                    if (empty($v))
                        $v = '---------';
                }

                $model['mes_refe'] = str_pad($model['mes_refe'], 2, '0', STR_PAD_LEFT);
                $model['data_empe'] = U::dataDoBanco($model['data_empe']);
                $model['valo_empe'] = 'R$ ' . number_format($model['valo_empe'], 2, ',', '.');

                $criteria = new CDbCriteria();
                $criteria->select = 'data_movi, desc_tpmo, nume_parc, valo_movi';
                //$criteria->order = 'nume_parc DESC';
                if (isset($query['empenho']))
                    $criteria->compare('nume_empe', $query['empenho']);
                if (isset($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);

                $mov = Despesa::model()->findAll($criteria);
                $movs = array();
                foreach ($mov as $m) {
                    $aux = array();
                    $aux['data_movi'] = U::dataDoBanco($m->data_movi);
                    $aux['desc_tpmo'] = $m->desc_tpmo;
                    $aux['nume_parc'] = $m->nume_parc;
                    $aux['valo_movi'] = 'R$ ' . number_format($m->valo_movi, 2, ',', '.');
                    $movs[] = $aux;
                }

                $count = Despesa::model()->count($criteria);
                break;
            default:
                $this->_sendResponse(501, sprintf(
                                'Error: Mode <b>list</b> is not implemented for model <b>%s</b>', $_GET['model']));
                Yii::app()->end();
        }

        if (empty($model)) {
            $this->_sendResponse(501, '', 'application/json');
        } else {

            switch ($_GET['model']) {
                case 'receita':
                    $json = array(
                        'data' => $model,
                        'count' => $count
                    );
                    break;
                case 'despesa':
                    $json = array(
                        'data' => $model,
                        'historico' => $movs,
                        'count' => $count
                    );
                    break;
            }
            $this->_sendResponse(200, CJSON::encode($json), 'application/json');
        }
    }

    public function actionTotal() {
        parse_str($_SERVER['QUERY_STRING'], $query);

        switch ($_GET['model']) {
            case 'receita':
                $criteria = new CDbCriteria();
                $criteria->select = 'SUM(valo_arre) as valo_arre';
                if (isset($query['ano']))
                    $criteria->compare('ano_refe', $query['ano']);

                $total = Receita::model()->find($criteria);
                $total = $total->valo_arre;
                break;
            case 'despesa':
                $mes = ((isset($query['mes'])))?('AND mes_refe = '.$query['mes']):('');
                $sql = "
                    SELECT SUM(d.valo_empe) as valo_empe 
                    FROM(
                        SELECT DISTINCT nume_empe, valo_empe 
                        FROM despesa_lei131 
                        WHERE ano_refe = {$query['ano']} {$mes}
                        ) d";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $total = $command->queryRow();
                $total = $total['valo_empe'];
                break;
            default:
                $this->_sendResponse(501, sprintf(
                                'Error: Mode <b>total</b> is not implemented for model <b>%s</b>', $_GET['model']));
                Yii::app()->end();
        }

        if (empty($total)) {
            $this->_sendResponse(501, '', 'application/json');
        } else {
            $json = array(
                'total' => 'R$ ' . number_format($total, 2, ',', '.')
            );
            $this->_sendResponse(200, CJSON::encode($json), 'application/json');
        }
    }

    public function actionFiltro() {
        parse_str($_SERVER['QUERY_STRING'], $query);

        switch ($_GET['model']) {
            case 'receita':
                $entidades = Entidade::model()->cache(3600)->findAll();
                $json = array(
                    'entidades' => $this->modelToArray($entidades),
                );
                break;
            case 'despesa':
                //Entidade
                $entidades = Entidade::model()->cache(3600)->findAll();

                //Tipo Empenho
                $criteria = new CDbCriteria();
                $criteria->distinct = true;
                $criteria->select = 'desc_tpem';
                $criteria->order = 'desc_tpem ASC';
                $despesas = Despesa::model()->cache(3600)->findAll($criteria);
                $tipoEmpenhos = array();
                foreach ($despesas as $m) {
                    $aux = array();
                    $aux['tipo'] = $m->desc_tpem;
                    $tipoEmpenhos[] = $aux;
                }

                //Fonte de Recursos
                $criteria = new CDbCriteria();
                $criteria->distinct = true;
                $criteria->select = 'desc_forc';
                $criteria->order = 'desc_forc ASC';
                $despesas = Despesa::model()->cache(3600)->findAll($criteria);
                $fontes = array();
                foreach ($despesas as $m) {
                    $aux = array();
                    $aux['fonte'] = $m->desc_forc;
                    $fontes[] = $aux;
                }

                $json = array(
                    'entidades' => $this->modelToArray($entidades),
                    'tipoEmpenhos' => $tipoEmpenhos,
                    'fonteRecursos' => $fontes
                );
                break;
            default:
                $this->_sendResponse(501, sprintf(
                                'Error: Mode <b>filtro</b> is not implemented for model <b>%s</b>', $_GET['model']));
                Yii::app()->end();
        }

        $this->_sendResponse(200, CJSON::encode($json), 'application/json');
    }

    public function actionOrgaos() {
        parse_str($_SERVER['QUERY_STRING'], $query);

        switch ($_GET['model']) {
            case 'despesa':

                //Orgãos
                $orgaoNotIn = array_keys($this->orgaoParaTratar);
                $orgaoNotIn = implode("','", $orgaoNotIn);
                $orgaoNotIn = "'" . $orgaoNotIn . "'";
                $criteria = new CDbCriteria();
                $criteria->distinct = true;
                $criteria->select = 'desc_orga';
                $criteria->condition = "desc_orga NOT IN ({$orgaoNotIn})";
                $criteria->order = 'desc_orga ASC';
                $despesas = Despesa::model()->cache(3600)->findAll($criteria);
                $orgaos = array();
                foreach ($despesas as $m) {
                    $aux = array();
                    $aux['orgao'] = $m->desc_orga;
                    $orgaos[] = $aux;
                }

                $json = array(
                    'orgaos' => $orgaos,
                );
                break;
            default:
                $this->_sendResponse(501, sprintf(
                                'Error: Mode <b>orgaos</b> is not implemented for model <b>%s</b>', $_GET['model']));
                Yii::app()->end();
        }

        $this->_sendResponse(200, CJSON::encode($json), 'application/json');
    }

    private function _checkAuth() {
        if (!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
            $this->_sendResponse(401);
        }
        $username = $_SERVER['HTTP_X_USERNAME'];
        $password = $_SERVER['HTTP_X_PASSWORD'];
        $user = User::model()->find('LOWER(username)=?', array(strtolower($username)));
        if ($user === null) {
            $this->_sendResponse(401, 'Error: User Name is invalid');
        } else if (!$user->validatePassword($password)) {
            $this->_sendResponse(401, 'Error: User Password is invalid');
        }
    }

    private function _getStatusCodeMessage($status) {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);
        header('Access-Control-Allow-Origin: *');

        if ($content_type == 'application/json') {
            $body = (isset($_REQUEST['callback'])) ? ($_REQUEST['callback'] . "({$body})") : ($body);
            echo $body;
        } else if ($content_type == 'text/html') {

            if ($body != '') {
                echo $body;
            } else {
                $message = '';

                switch ($status) {
                    case 401:
                        $message = 'You must be authorized to view this page.';
                        break;
                    case 404:
                        $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                        break;
                    case 500:
                        $message = 'The server encountered an error processing your request.';
                        break;
                    case 501:
                        $message = 'The requested method is not implemented.';
                        break;
                }

                $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

                $body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
</head>
<body>
    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
    <p>' . $message . '</p>
    <hr />
    <address>' . $signature . '</address>
</body>
</html>';

                echo $body;
            }
        }
        Yii::app()->end();
    }

    private function modelToArray($models) {
        $rows = array();
        foreach ($models as $model)
            $rows[] = $model->attributes;
        return $rows;
    }

    public function actionTelefones() {
        $id = 'fonecache';
        $telefones = Yii::app()->cache->get($id);
        if ($telefones === false) {
            $telefones = file_get_contents('http://www.fomsege.com.br/telefones-uteis.php');
            $telefones = unserialize($telefones);
            Yii::app()->cache->set($id, $telefones, 3600);
        }

        $telefones = array(
            'data' => $telefones
        );
        $this->_sendResponse(200, CJSON::encode($telefones), 'application/json');
    }

    public function actionOuvidoria() {

        if ($_GET['tipo'] == 0) {
            $body = "
            <h1>Demanda do Aplicativo: transparênciaJP</h1>
            <p>
                <strong>Nome:</strong> {$_GET['nome']}<br />
                <strong>Email:</strong> {$_GET['email']}<br />
                <strong>Gênero:</strong> {$_GET['genero']}<br />
                <strong>Orientação Sexual:</strong> {$_GET['orientacao']}<br />
                <strong>Etnia:</strong> {$_GET['etnia']}<br />
                <strong>Idade:</strong> {$_GET['idade']}<br />
                <strong>Endereço:</strong> {$_GET['endereco']}<br />
                <strong>Telefone Residencial:</strong> {$_GET['telefoneResidencial']}<br />
                <strong>Telefone Comercial:</strong> {$_GET['telefoneComercial']}<br />
                <strong>Telefone Celular:</strong> {$_GET['telefoneCelular']}<br />
                <strong>Mensagem:</strong> {$_GET['mensagem']}<br />
            </p>
";
        } else if ($_GET['tipo'] == 1) {
            $body = "
            <h1>Demanda Anônima do Aplicativo: transparênciaJP</h1>
            <p>
                <strong>Mensagem:</strong> {$_GET['mensagem']}<br />
            </p>
";
        }
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer(true);
        try {
            $mail->IsSMTP();
            $mail->Host = 'mail.fomsege.com.br';
            $mail->Port = '465';
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = 'naoresponda@fomsege.com.br';
            $mail->Password = 'fomsege2013';
            $mail->Mailer = "smtp";
            $mail->SMTPKeepAlive = true;
            $mail->CharSet = 'utf-8';
            $mail->SetFrom('naoresponda@fomsege.com.br', 'Nao responda');
            $mail->AddReplyTo('naoresponda@fomsege.com.br', 'Nao responda');
            $mail->Subject = "Demanda transparenciaJP - " . $_GET['email'];
            $mail->Body = $body;
            $mail->IsHTML(true);
            $mail->AddAddress('joao.2507@gmail.com');
            $mail->AddAddress('ouvidoriapmjp@gmail.com');
            $mail->AddAddress('maschoff@gmail.com');
            $mail->SMTPDebug = 0;
            $mail->MailerDebug = false;
            @$mail->Send();
            $json = array(
                'erro' => '0',
                'mensagem' => 'Muito obrigado por colaborar com a gestão municipal. Sua mensagem foi enviada com sucesso.'
            );
        } catch (phpmailerException $e) {
            $json = array(
                'erro' => '1',
                'mensagem' => 'Não foi possível enviar a mensagem, por favor nos informe: 3218-5680. <br />Erro: ' . $e->errorMessage()
            );
        } catch (Exception $e) {
            $json = array(
                'erro' => '1',
                'mensagem' => 'Não foi possível enviar a mensagem, por favor nos informe: 3218-5680. <br />Erro: ' . $e->getMessage()
            );
        }
        $this->_sendResponse(200, CJSON::encode($json), 'application/json');
    }

    function actionCheckOnline() {
        $this->_sendResponse(200, CJSON::encode(array('data' => 'online')), 'application/json');
    }

}

?>
