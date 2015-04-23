# Vshost File
<br/><br/>
`<VirtualHost *:80>`<br/>
`DocumentRoot /data2/www/hq/hq/`<br/>
`ServerName dev.hq.com`<br/>
`<Directory "/data2/www/hq/hq/">`<br/>
`Options Indexes FollowSymLinks MultiViews`<br/>
`AllowOverride All`<br/>
`Order allow,deny`<br/>
`allow from all`<br/>
`</Directory>`<br/>
`ErrorLog /data2/www/hq/hq/apache.log`<br/>
`</VirtualHost>`<br/>

<br/><br/>
# Site Name<br/>
dev.hq.com

<br/><br/>
# Bonus question<br/>
How would you handle security for saving credit cards?<br/><br/>

1). I would follow the steps in https://www.pcisecuritystandards.org/security_standards/documents.php<br/>
2). For more security I will encrypt the CC info using encryption mechanism<br/>
3). If we are not using recurring payments then I wont save the credit card information initially because without a specific requirement saving credit card info is a high risk to the organization<br/>


