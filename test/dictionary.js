function show() {
  var x = document.getElementById("category");
  if (x.style.display === "none") {
    x.style.display = "block";
    document.getElementById("searchByCategory").classList.remove("search-by-category");
    document.getElementById("searchByCategory").classList.add("search-by-category-after");
  } else {
    x.style.display = "none";
    document.getElementById("searchByCategory").classList.remove("search-by-category-after");
    document.getElementById("searchByCategory").classList.add("search-by-category");
  }

  var button = document.querySelector('.show');
  if (button.innerHTML === 'show') {
    button.innerHTML = 'hide';
  } else {
    button.innerHTML = 'show';
  }

  var arrow = document.querySelector('.arrow');
  if (arrow.classList.contains('up')) {
    arrow.classList.remove('up');
    arrow.classList.add('down');
  } else {
    arrow.classList.remove('down');
    arrow.classList.add('up');
  }
}

function showLang() {

var x = document.getElementById("langSelectMore");
var showMoreButton = document.querySelector('.showMore');

if (x.style.display === "none") {
  x.style.display = "block";
  showMoreButton.innerHTML = 'see less⠀<i class="arrow-filter up-filter"></i>';
} else {
  x.style.display = "none";
  showMoreButton.innerHTML = 'see more⠀<i class="arrow-filter down-filter"></i>';
}

  var arrow = document.querySelector('.arrow-filter');
  if (arrow.classList.contains('up-filter')) {
    arrow.classList.remove('up-filter');
    arrow.classList.add('down-filter');
  } else {
    arrow.classList.remove('down-filter');
    arrow.classList.add('up-filter');
  }
}

function showType() {

var x = document.getElementById("typeSelectMore");
var showMore2Button = document.querySelector('.showMore2');

if (x.style.display === "none") {
x.style.display = "block";
showMore2Button.innerHTML = 'see less⠀<i class="arrow-filter2 up-filter"></i>';
} else {
x.style.display = "none";
showMore2Button.innerHTML = 'see more⠀<i class="arrow-filter2 down-filter"></i>';
}
  
var arrow = document.querySelector('.arrow-filter2');
if (arrow.classList.contains('up-filter')) {
  arrow.classList.remove('up-filter');
  arrow.classList.add('down-filter');
} else {
  arrow.classList.remove('down-filter');
  arrow.classList.add('up-filter');
}
}

document.addEventListener("DOMContentLoaded", function() {
  var segmentedOptions = document.querySelectorAll('.segmented-control input[type="radio"]');
  segmentedOptions.forEach(function(option) {
    option.addEventListener('change', function() {
      var selectedValue = this.value;
      console.log("Selected value:", selectedValue);
      // ทำสิ่งที่คุณต้องการเมื่อมีการเลือกตัวเลือกใน segmented control
    });
  });
});

function checkAll(groupName) {
  var checkboxes = document.querySelectorAll('.' + groupName);
  var selectAllButton = document.getElementById(groupName + 'AllBtn');

  var allChecked = true;
  checkboxes.forEach(function(checkbox) {
    if (!checkbox.checked) {
      allChecked = false;
    }
  });

  checkboxes.forEach(function(checkbox) {
    checkbox.checked = !allChecked;
  });

  selectAllButton.textContent = allChecked ? 'Select All' : 'Unselect All';
}

function sortFunction() {
  var selectBox = document.getElementById("sortBy");
  var selectedValue = selectBox.options[selectBox.selectedIndex].value;

  // Check the selected value
  if (selectedValue === "AZ") {
    // Sort in ascending order (A to Z)
    // Your sorting logic here
    console.log("Sorting A to Z");
  } else if (selectedValue === "ZA") {
    // Sort in descending order (Z to A)
    // Your sorting logic here
    console.log("Sorting Z to A");
  }
}

function changeWordIPA1() {
  var phoneticElement = document.getElementById('wordphonetic1');
  var ipaElement = document.getElementById('wordipa1');
  var showButton = document.querySelector('.showIPA');

  if (phoneticElement.classList.contains('hide')) {
      // แสดง phonetic ซ่อน ipa
      phoneticElement.classList.remove('hide');
      ipaElement.classList.add('hide');
      // เปลี่ยนข้อความของปุ่ม
      showButton.innerHTML = '<div class="showIPA">SHOW IPA</div>';
  } else {
      // แสดง ipa ซ่อน phonetic
      phoneticElement.classList.add('hide');
      ipaElement.classList.remove('hide');
      // เปลี่ยนข้อความของปุ่ม
      showButton.innerHTML = '<div class="showIPA">PHONETIC SPELLING</div>';
  }
}

var audio = document.getElementById('pronounce');
var isPlaying = false;

function playAudio() {
  if (!isPlaying) {
    isPlaying = true;
    audio.play();
    audio.addEventListener('ended', function() {
      isPlaying = false;
    });
  } else {
    audio.pause();
    audio.currentTime = 0;
    isPlaying = false;
  }
}

audio.addEventListener('ended', function() {
  audio.pause();
  isPlaying = false;
});