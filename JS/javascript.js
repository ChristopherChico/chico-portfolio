function openFacebook() {
     window.open('https://www.facebook.com/Christopher.Jake.Chico/', '_blank');
   }

function openGitHub() {
      window.open('https://github.com/ChristopherChico', '_blank');
   }

function openSpotify() {
      window.open('https://open.spotify.com/user/fte46oitsfx7zztw96zxe7veo', '_blank');
   }

function aboutFunction() {
      location.replace("about.html");
   }

function goBack() {
      location.replace("Chico's Portfolio.html");
}

function skillFunction() {
      location.replace("skill.html");
   }

function contactFunction() {
     
   }

let quoteButtonClicked = false;

  function getRandomQuote() {
    if (quoteButtonClicked) {
      return;
    }

    quoteButtonClicked = true;

    fetch('https://api.quotable.io/random')
      .then(response => response.json())
      .then(data => {
        const quote = data.content;
        const author = data.author;

        alert(`${quote} - ${author}`);

        quoteButtonClicked = false;
      })
}



var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

function openModal() {
  modal.style.display = "block";
}

function closeModal() {
  modal.style.display = "none";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
      closeModal();
    }
};
