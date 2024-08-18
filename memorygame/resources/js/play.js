$(document).ready(function () {
  var selection = [];
  var remcards = 0;
  let startTime;
  let updatedTime;
  let difference;
  let tInterval;
  let running = false;

  function startTimer() {
    if (!running) {
      startTime = new Date().getTime();
      tInterval = setInterval(updateTimer, 1);
      running = true;
    }
  }

  function stopTimer() {
    clearInterval(tInterval);
    running = false;
  }

  function resetTimer() {
    clearInterval(tInterval);
    running = false;
    document.getElementById("watch").innerHTML = "00:00:00.000";
  }

  function updateTimer() {
    updatedTime = new Date().getTime();
    difference = updatedTime - startTime;

    let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((difference % (1000 * 60)) / 1000);
    let milliseconds = Math.floor(difference % 1000);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;
    milliseconds = milliseconds < 100 ? "0" + milliseconds : milliseconds;
    milliseconds = milliseconds < 10 ? "00" + milliseconds : milliseconds;

    document.getElementById("watch").innerHTML =
      minutes + ":" + seconds + "." + milliseconds;
  }
  async function sleep(ms) {
    await new Promise((resolve) => setTimeout(resolve, ms));
  }
  $.ajax({
    type: "POST",
    url: "/resources/backend/play.php",
    data: {
      playername: 0,
      board: 0,
    },
    success: function (response) {
      response = JSON.parse(response);
      $(".board").html(response.board);
      resetTimer();
      startTimer();
    },
  });
  $(document).on("click", ".cover", async function () {
    if (selection.length < 2) {
      if (!selection.includes($(this).attr("id"))) {
        selection.push($(this).attr("id"));
      }
      $(this)
        .css("background-color", "transparent")
        .css("backdrop-filter", "blur(0)");
      if (selection.length == 2) {
        await sleep(1024);
        var sel1 = $("#" + selection[0]).attr("class");
        var sel2 = $("#" + selection[1]).attr("class");
        if (sel1 == sel2) {
          $("." + sel1.replace("cover", "cards").replace(" ", " .")).slideUp();
          remcards += 2;
        } else {
          $(".cover").css("background-color", "#242424");
        }
        selection = [];
      }
    }
    if (remcards == 16) {
      stopTimer();
      $.ajax({
        type: "post",
        url: "/resources/backend/recordgame.php",
        data: {
            time : document.getElementById("watch").innerHTML
        },
        success: function (response) {
            response = JSON.parse(response);
            $(".dialogview").css("display", "grid");
            $(".gameid").html("<span>Game ID : </span>" + response.gameID);
            $(".playername").html("<span>Player Name : </span>" + response.playername);
            $(".time").html("<span>Time : </span>" + response.time);
        }
      });
    }
  });
});
