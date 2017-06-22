一、yii2后台项目
二、站点配置
server {
        listen       80;
        server_name  xz.xxcb.dev;
        location / {
            root   E:/site/xy.xxcb.cn/backend/web;
            index  index.html index.htm index.php;
            #autoindex  on;
             if (!-e $request_filename){
                rewrite ^/(.*) /index.php?r=$1 last;
            }
        }
        location ~ \.php$ {
            fastcgi_pass   10.0.7.64:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME   /data/winfile/gongjt/xy.xxcb.cn/backend/web/$fastcgi_script_name;
            include        fastcgi_params;
        }
}