<?php
/**
 * rep2 - 2chログイン
 */

// {{{ authenticate_2chapi()

/**
 * 2ch IDにログインする
 *
 * @return  string|false  成功したら2chAPI SIDを返す
 */


/**
     * 2chAPIの SID を取得する
     *
     * @return mix 取得できた場合はSIDを返す
     */
    function authenticate_2chapi($AppKey, $HMKey)
    {
       global $_conf;
        $url = 'https://api.2ch.net/v1/auth/';
        $CT = time();
        $message = $AppKey.$CT;
        $HB = hash_hmac("sha256", $message, $HMKey);
        $values = array(
            'ID' => '',
            'PW' => '',
            'KY' => $AppKey,
            'CT' => $CT,
            'HB' => $HB,
        );
        $options = array('http' => array(
            'ignore_errors' => true,
            'method' => 'POST',
            'header' => implode("\r\n", array(
                'User-Agent: ',
                'X-2ch-UA: JaneStyle/3.80',
                'Content-Type: application/x-www-form-urlencoded',
            )),
            'content' => http_build_query($values),
        ));
        
        $response = '';
        $response = file_get_contents($url, false, stream_context_create($options));
        
        if (strpos($response, ':') != false)
        {
            $sid = explode(':', $response);
            
            $cont = sprintf('<?php $SID2chAPI = %s;', var_export($sid[1], true));
               if (false === file_put_contents($_conf['sid2chapi_php'], $cont, LOCK_EX)) {
                       P2Util::pushInfoHtml("<p>p2 Error: {$_conf['sid2chapi_php']} を保存できませんでした。ログイン登録失敗。</p>");
                       return '';
               }
            
            return $sid[1];
        }
        
        return '';
    }
// }}}

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker: