<?PHP

$data['name'] = $_POST['name']; //姓名
$data['email'] = $_POST['email']; //email
$data['suggestion'] = $_POST['suggestion']; //意见


//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告

require_once("class.phpmailer.php"); 
require_once("class.smtp.php");

//示例化PHPMailer核心类
$mail = new PHPMailer();
 
//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
// $mail->SMTPDebug = 1;
 
//使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
//可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
$mail->isSMTP();
//smtp需要鉴权 这个必须是true
$mail->SMTPAuth=true;
//链接163域名邮箱的服务器地址
$mail->Host = 'smtp.163.com';
//设置使用ssl加密方式登录鉴权
$mail->SMTPSecure = 'ssl';
//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
$mail->Port = 465;

//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
$mail->CharSet = 'UTF-8';

//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
$mail->FromName = $data['name'] ;

//smtp登录的账号 这里填入字符串格式的163号即可
$mail->Username ='junstitch@163.com';

//smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
$mail->Password = '您163的第三方授权密码';

//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
$mail->From = 'junstitch@163.com';

//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
$mail->isHTML(true); 

//设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
$mail->addAddress('junstitch@qq.com');

$mail->Subject = '邮件标题';
//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
$mail->Body = "<div id ='client_email'>我的邮箱：".$data['email']."</div><p>".$data['suggestion']."</p>";
 
 
//发送命令 返回布尔值 
//PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
$status = $mail->send();
 
//简单的判断与提示信息
if($status) {
 echo 'send successfully';
}else{
 echo 'send error  '.$mail->ErrorInfo;
}
?>