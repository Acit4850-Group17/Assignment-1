<div id="registration">
    <h2>Registration:</h1>
    <form action="/Registration/signup" method="POST" enctype="multipart/form-data">
        <div><span>Username: </span><input type="text" name="username" /></div>
        <div><span>Password: </span><input type="password" name="password" /></div>
        <div><span>Avatar: </span><input type="file" name="avatar"/></div>
        <div><span> </span><input type="submit" value="Register"/></div>
    </form>
    <div>
        Note: Avatars must be 256px by 256px.
    </div>
    <div>
        {error}
    </div>
</div>
