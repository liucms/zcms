liucms@

cloudflare批量添加域名及添加dns解析记录php脚本

原理： 程序会循环读取domain.txt的每一行通过cloudflare接口添加，并将record.txt中的记录每一个域名对应一行。 接口参考：https://api.cloudflare.com/

目前支持A、CNAME记录批量添加。

配置方法：

1、首先修改cloudflare.php中 $header = array( "X-Auth-Email:xxx@qq.com", "X-Auth-Key:xxx", "Content-Type:application/json" );

X-Auth-Email及X-Auth-Key参数从cloudflare后台中查看。其它部分代码不需修改。

2、domain.txt为待加入的域名列表，一行一个，文件编码为utf-8，格式为windows（cr lf）格式（务必）。推荐用notepad++编辑。

3、record.txt为待加入的解析列表。一行一个。文件编码为utf-8，格式为windows（cr lf）格式（务必）。每行解析值分3列，以逗号分隔，第一列为主机记录，如www，第二列为记录类型，如A记录，第三列为值，如114.114.114.114，解析多条记录中间用 | 下划线隔开

4、推荐在命令行中执行 php cloudflare.php，不要在浏览器中访问。

m3u8-hls HTML5播放器 https://github.com/video-dev/hls.js/releases

jQuery https://code.jquery.com/

jQuery Cookie https://plugins.jquery.com/cookie/
