function teaBasic() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp020_basic.php", true);
  xhttp.send();
}

function teaPicUpdate() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/present.php", true);
  xhttp.send();
}

function teaPresent() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp041_change.php", true);
  xhttp.send();
}

function teaPreWork() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/pre_work.php", true);
  xhttp.send();
}

function teaWorkingHistory() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/incareer.php", true);
  xhttp.send();
}

function teaWithAdministratorHistory() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/tea_plural.php", true);
  xhttp.send();
}

function teaEducationHistory() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp023_edu.php", true);
  xhttp.send();
}

function teaResumeForm() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_sketch_proc_main.php", true);
  xhttp.send();
}

function teaResumeToPDF() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_sketch_rtp.php", true);
  xhttp.send();
}
function teaProfUpgrade() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp168_prof_upgrade.php", true);
  xhttp.send();
}
function teaReward() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp144_reward.php", true);
  xhttp.send();
}
function teaSalary() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp119_salary.php", true);
  xhttp.send();
}
function teaCommutnicationQuery() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_address_book_query.php", true);
  xhttp.send();
}

function teaCheckPresident() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_work_check_president.php", true);
  xhttp.send();
}
function teaCheckManager() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_work_check_manager.php", true);
  xhttp.send();
}
