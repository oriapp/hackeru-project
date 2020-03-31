


$('#image-field').on('change', function (e) {
  $(this).next().text(e.target.files[0].name);
});

$('.delete-post-btn').on('click', function () {

  if (confirm('Are you sure you want to delete this post?')) {
    return true;
  } else {
    return false;
  }

});

let submit = document.getElementById("submit");


let art = document.getElementById("article");
let spn = document.getElementById("article1");
  
if (spn && art) {
  let art = document.getElementById("article");
  let spn = document.getElementById("article1");
  let lim = 4000;
  
  art.oninput = function () {
    let len = art.value.length;
    if (len < 100) {
      spn.innerHTML = `<code>*</code> ${len} / ${lim}`;
      spn.style.color = "white";
    } else {
      spn.innerHTML = `<code>*</code> ${len} / ${lim}`;
      spn.style.color = "#FFFF00";
    }
  
    if (len == lim || len > lim) {
      article.disabled = true;
    }
  }


window.onload = function () {
  let len = art.value.length;
  if (len < 100) {
    spn.innerHTML = `<code>*</code> ${len} / ${lim}`;
    spn.style.color = "white";
  } else {
    spn.innerHTML = `<code>*</code> ${len} / ${lim}`;
    spn.style.color = "#FFFF00";
  }

  if (len == lim || len > lim) {
    article.disabled = true;
  }
  }

}