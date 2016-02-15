$(document).ready(function(){

  //Delegating event handlers for various clicks

  //Delegation for assembling

  //Checks that the selected piece belongs to the signed in user,
  //Then puts in into the assembler
  //Ideally would also store the token as an attribute for later verification (for next assignment)
  $("#assemblerInventory").on("click", ".botpiece", function(){
        var token = $(this).attr("data-token");
        console.log(token);
        $.ajax({
          url: "/get_collection_by_token",
          type: 'POST',
          data: ("token=" + token),
          dataType: 'json',
          success: function(data) {
              if(data.message == "success"){
                switch (data.CardPosition){
                  case "0":
                    $("#headPiece > img").attr("src", "/assets/images/" + data.Series + data.SubSeries + "-" + data.CardPosition + ".jpeg");
                    break;
                  case "1":
                    $("#midPiece > img").attr("src", "/assets/images/" + data.Series + data.SubSeries + "-" + data.CardPosition + ".jpeg");
                    break;
                  case "2":
                    $("#legPiece > img").attr("src", "/assets/images/" + data.Series + data.SubSeries + "-" + data.CardPosition + ".jpeg");
                    break;
                  default:
                    break;
                }
              }
              else{
                alert("That is not your piece!");
              }
          }
        });
    });

    //Removes bot pieces on clicking one in the assembler
    $("#assemblerInventory").on("click", ".assemblerPiece", function(){
      $(this).children("img").attr("src", "/assets/images/unknown.jpeg");
    });

    //resets the assembler loading area when you submit a built bot
    $("#assemblerArea").on("click", "#assembleButton", function(){
      $("#assemblerArea").children("div").children("img").attr("src", "/assets/images/unknown.jpeg");
      alert('Not implemented yet!');
    });

    //Delegation for general logging and and out

   //Calls a function to set username, and set loggedin to true
    $("body").on("click", "#btnLogin", function(){
      var username = $(this).siblings('input').val();

      $.ajax({
        url: "/login",
        type: 'POST',
        data: ("username=" + username),
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
