<?php
/**
 * rep2 - �ݒ�Ǘ��y�[�W
 */

require_once __DIR__ . '/../init.php';

$_login->authorize(); // ���[�U�F��

// �����o���p�ϐ� ========================================
$ptitle = '���O�C���Ǘ�';

if ($_conf['ktai']) {
    $status_st = "�ð��";
    $autho_user_st = "�F��հ��";
    $client_host_st = "�[��ν�";
    $client_ip_st = "�[��IP���ڽ";
    $browser_ua_st = "��׳��UA";
    $p2error_st = "rep2 �װ";
} else {
    $status_st = "�X�e�[�^�X";
    $autho_user_st = "�F�؃��[�U";
    $client_host_st = "�[���z�X�g";
    $client_ip_st = "�[��IP�A�h���X";
    $browser_ua_st = "�u���E�UUA";
    $p2error_st = "rep2 �G���[";
}

$autho_user_ht = "{$autho_user_st}: {$_login->user_u}<br>";

// HOST���擾
if (array_key_exists('REMOTE_HOST', $_SERVER)) {
    $hc['remote_host'] = $_SERVER['REMOTE_HOST'];
} else {
    $hc['remote_host'] = '';
}
if (!$hc['remote_host']) {
    $hc['remote_host'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
}
if ($hc['remote_host'] == $_SERVER['REMOTE_ADDR']) {
    $hc['remote_host'] = '';
}

$hc['ua'] = $_SERVER['HTTP_USER_AGENT'];

$hd = array_map('p2h', $hc);

//=========================================================
// HTML�v�����g
//=========================================================
P2Util::header_nocache();
echo $_conf['doctype'];
echo <<<EOP
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    {$_conf['extra_headers_ht']}
    <title>{$ptitle}</title>\n
EOP;

if (!$_conf['ktai']) {
    echo <<<EOP
    <link rel="stylesheet" type="text/css" href="css.php?css=style&amp;skin={$skin_en}">
    <link rel="stylesheet" type="text/css" href="css.php?css=setting&amp;skin={$skin_en}">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <script type="text/javascript" src="js/basic.js?{$_conf['p2_version_id']}"></script>\n
EOP;
}

$body_at = ($_conf['ktai']) ? $_conf['k_colors'] : ' onload="setWinTitle();"';
echo <<<EOP
</head>
<body{$body_at}>
EOP;

// �g�їp�\��
if (!$_conf['ktai']) {
    echo <<<EOP
<p id="pan_menu">���O�C���Ǘ�</p>
EOP;
}

// �C���t�H���b�Z�[�W�\��
P2Util::printInfoHtml();

echo <<<EOP
<ul id="setting_menu">
    <li><a href="login.php{$_conf['k_at_q']}">rep2���O�C���Ǘ�</a></li>
    <li><a href="login2ch.php{$_conf['k_at_q']}">2ch���O�C���Ǘ�</a></li>
</ul>
EOP;

if ($_conf['ktai']) {
    echo '<hr>';
}

echo <<<EOP
<p id="client_status">
{$autho_user_ht}
{$client_host_st}: {$hd['remote_host']}<br>
{$client_ip_st}: {$_SERVER['REMOTE_ADDR']}<br>
{$browser_ua_st}: {$hd['ua']}
</p>
EOP;


// �t�b�^�v�����g===================
if ($_conf['ktai']) {
    echo "<hr><div class=\"center\">{$_conf['k_to_index_ht']}</div>";
}

echo '</body></html>';

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