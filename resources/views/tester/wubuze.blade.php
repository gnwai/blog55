<form method="post" action="http://up.qiniup.com" enctype="multipart/form-data">
    <input name="token" type="hidden" value="{{ $token }}">
    <input name="file" type="file" />
    <input name="key" value="{{ $name }}.jpg" />
    <input type="submit" value="上传"/>
</form>
