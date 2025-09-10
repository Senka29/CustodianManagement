function saveClientTime() {
      const now = new Date().toISOString().slice(0, 19).replace("T", " "); // format yyyy-mm-dd hh:mm:ss
      
      fetch("save_time.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "client_time=" + encodeURIComponent(now)
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById("status").innerText = data;
      });
    }