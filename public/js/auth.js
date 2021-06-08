function logout() {
    fetch('/logout',{
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        method: "POST",
        body: ""
    })
        .then(function(response) {
            return response.json();
        })
}
