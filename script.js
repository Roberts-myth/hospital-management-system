function loadNavbar() { // fetches the html content of the navbar
    fetch('navbar.html')    // html is moved into anywhere with the navbar-container class
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar-container').innerHTML = data;
      })
      .catch(error => console.error('Error loading navbar:', error));
  }