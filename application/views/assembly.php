<div class="playerInventory" id="assemblerInventory">
	{inventory_table}

	<div id="buyBotContainer">
		<form action="/Assembly/buy_bot">
			<input type="submit" value="Buy new bots!"/>
		</form>
		<div id="buyBotMessageBox">
			{message}
		</div>
	</div>

</div>


<div id="assemblerArea">
	<h3>Assembly Area:</h3>
	<div class="assemblerPiece" id="headPiece">
		<img src='/assets/images/unknown.jpeg' alt='Unkown!'>
	</div>

	<div class="assemblerPiece" id="midPiece">
		<img src='/assets/images/unknown.jpeg' alt='Unkown!'>
	</div>

	<div class="assemblerPiece" id="legPiece">
		 <img src='/assets/images/unknown.jpeg' alt='Unkown!'>
	</div>

	<div id="assembleButton">
		<input type="button" value="ASSEMBLE!">
	</div>
</div>
