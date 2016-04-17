$(document).ready(function(){

  //Delegating event handlers for various clicks

  //Delegation for assembling

  //Checks that the selected piece belongs to the signed in user,
  //Then puts in into the assembler
  //Ideally would also store the token as an attribute for later verification (for next assignment)
  $("#assemblerInventory").on("click", ".botpiece", function(){
        var token = $(this).attr("data-token");
        $.ajax({
          url: "/Assembly/select_bot",
          type: 'POST',
          data: ("token=" + token),
          dataType: 'json',
          success: function(data) {
              console.log(data);
              if(data.message == "success"){
                type = (data.piece).split("-")[1]; //gets the last part, after the '-' of the returned piece
                switch (type){
                  case "0":
                    $("#headPiece > img").attr("src", "/assets/images/" + data.piece + ".jpeg");
                    $("#headPiece > img").attr("data-token", token);

                    break;
                  case "1":
                    $("#midPiece > img").attr("src", "/assets/images/" + data.piece + ".jpeg");
                    $("#midPiece > img").attr("data-token", token);
                    break;
                  case "2":
                    $("#legPiece > img").attr("src", "/assets/images/" + data.piece + ".jpeg");
                    $("#legPiece > img").attr("data-token", token);
                    break;
                  default:
                    break;
                }
              }
              else{
                alert("That is not your piece!");
              }
          },
          error: function (jqXHR, textStatus, errorThrown){
			alert('Error with the connection: ' + textStatus + " " + errorThrown);
        }
        });
    });

    //Removes bot pieces on clicking one in the assembler
    $("#assemblerInventory").on("click", ".assemblerPiece", function(){
      $(this).children("img").attr("src", "/assets/images/unknown.jpeg");
    });

    //resets the assembler loading area when you submit a built bot
    $("#assemblerArea").on("click", "#assembleButton", function(){
        headPiece = $("#headPiece > img").attr("data-token");
        midPiece = $("#midPiece > img").attr("data-token");
        legPiece = $("#legPiece > img").attr("data-token");
        $.ajax({
          url: "/Assembly/sell_bot",
          type: 'POST',
          data: ("headPiece=" + headPiece + "&midPiece=" + midPiece + "&legPiece=" + legPiece),
          dataType: 'text',
          success: function(data) {
            alert(data);
            window.location.replace("/Assembly");
          },
          error : function (jqXHR, textStatus, errorThrown){
              alert('Error with the connection: ' + textStatus + " " + errorThrown);
         }
        });
    });

    //Delegation for general logging and and out

   //Calls a function to set username, and set loggedin to true
    $("body").on("click", "#btnLogin", function(){
      var username = $("#inputUsername").val();
      var password = $("#inputPass").val();


      $.ajax({
        url: "/login",
        type: 'POST',
        data: ("username=" + username + "&password=" + password),
        dataType: 'text',
        success: function(data) {
          console.log(data);
          window.location.reload();
        },
        error : function (jqXHR, textStatus, errorThrown){
			       alert('Error with the connection: ' + textStatus + " " + errorThrown);
           }
      });


    });

    //Calls a function to de-set username, and set loggedin to false
    $("body").on("click", "#btnLogout", function(){
      $.ajax({
        url: "/logout",
        type: 'POST',
        dataType: 'text',
        success: function(data) {
          console.log(data);
          window.location.reload();
        },
        error : function (jqXHR, textStatus, errorThrown){
			       alert('Error with the connection: ' + textStatus + " " + errorThrown);
       }

      });
    });

    //Delegation for selecting different portfolios via dropdown

    $("#body").on("change", "#selectPortfolio", function(){
      var selectedUser = $(this).children(":selected").val();
      window.location.href="/portfolio/" + selectedUser;
    });

});
