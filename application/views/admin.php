<div id="app-registration">
    <form action="/Admin/register" method="POST">
        <div>Team Number:<input type="text" name="team" value="B17"/></div>
        <div>Team Name: <input type="text" name="name"/></div>
        <div>Password: <input type="password" name="password"/></div>
        {registerButton}
    </form>
</div>

<div id="player-table">
    <table>
        <tr>
            <th>Player</th>
            <th></th>
            <th></th>
        </tr>
        {tableData}
    </table>
</div>
