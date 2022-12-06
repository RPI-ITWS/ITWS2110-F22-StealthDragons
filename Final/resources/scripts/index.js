// Cycle through product images
//https://www.youtube.com/watch?v=Y36QpYcnbQY
let thumbnails = document.getElementsByClassName("inactive-thumbnail");

let activeImg = document.getElementsByClassName("active-thumbnail");

if (thumbnails.length > 0) {
  for (var i = 0; i < thumbnails.length; i++) {
    thumbnails[i].addEventListener("mouseover", function () {
      if (activeImg.length > 0) {
        activeImg[0].classList.remove("active-thumbnail");
      }

      this.classList.add("active-thumbnail");
      document.getElementById("current-img").src = this.src;
    });
  }
}
let categorySelector = document.getElementById("category");
let subcategory1Selector = document.getElementById("subcategory-1");
let subcategory2Selector = document.getElementById("subcategory-2");
if (categorySelector != null) {
  categorySelector.addEventListener("change", async function () {
    let categoryValue = categorySelector.value;
    let formData = new FormData();
    formData.append("category", categoryValue);
    let fetchReponse = await fetch("./subcategories.php", {
      method: "POST",
      credentials: "same-origin",
      mode: "same-origin",
      body: formData,
    });
    let jsonData = await fetchReponse.json();
    replaceSubcategory1(jsonData);
  });
}
if (subcategory1Selector != null) {
  subcategory1Selector.addEventListener("change", async function () {
    let subcategoryValue = subcategory1Selector.value;
    let formData = new FormData();
    formData.append("subcategory", subcategoryValue);
    let fetchReponse = await fetch("./subcategories2.php", {
      method: "POST",
      credentials: "same-origin",
      mode: "same-origin",
      body: formData,
    });
    let jsonData = await fetchReponse.json();
    replaceSubcategory2(jsonData);
  });
}
function replaceSubcategory1(data) {
  subcategory1Selector.replaceChildren();
  subcategory2Selector.replaceChildren();
  subcategory1Selector.insertAdjacentHTML(
    "beforeend",
    "<option selected disabled>Select Subcategory</option>"
  );
  subcategory2Selector.insertAdjacentHTML(
    "beforeend",
    "<option selected disabled>Select Subcategory</option>"
  );
  for (let i = 0; i < data.length; i++) {
    let scID = String(data[i]["id"]);
    let scSC = String(data[i]["subcategory1"]);
    let scHTML = '<option value="' + scID + '">' + scSC + "</option>";
    subcategory1Selector.insertAdjacentHTML("beforeend", scHTML);
  }
}

function replaceSubcategory2(data) {
  subcategory2Selector.replaceChildren();
  subcategory2Selector.insertAdjacentHTML(
    "beforeend",
    "<option selected disabled>Select Subcategory</option>"
  );
  for (let i = 0; i < data.length; i++) {
    let scID = String(data[i]["id"]);
    let scSC = String(data[i]["subcategory2"]);
    let scHTML = '<option value="' + scID + '">' + scSC + "</option>";
    subcategory2Selector.insertAdjacentHTML("beforeend", scHTML);
  }
}

function setToCreate() {
  document.getElementsByClassName("list-item-modal")[0].innerHTML =
    "List an Item";
  document.getElementById("list-or-edit-button").name = "post-item";
  document.getElementById("list-or-edit-button").innerHTML = "List your Item!";
  document.getElementById("post-item-title").value = "";
  document.getElementById("post-item-price").value = "";
  document.getElementById("condition").value = "select-condition";
  document.getElementById("post-item-description").value = "";
}

function setToEdit(thisElement) {
  document.getElementsByClassName("list-item-modal")[0].innerHTML =
    "Edit an Item";
  document.getElementById("list-or-edit-button").name = "edit-item";
  document.getElementById("list-or-edit-button").innerHTML = "Confirm Edits";
  let rowid = thisElement.value;
  document.getElementById("post-item-title").value = document.getElementById(
    "title-" + rowid
  ).value;
  document.getElementById("post-item-price").value = document.getElementById(
    "price-" + rowid
  ).value;
  document.getElementById("condition").value = document.getElementById(
    "item_condition-" + rowid
  ).value;
  document.getElementById("post-item-description").value =
    document.getElementById("item_description-" + rowid).value;
  // document.getElementById("category").value = document.getElementById(
  //   "category-" + rowid
  // ).value;
  // document.getElementById("subcategory-1").value = document.getElementById(
  //   "subcategory1-" + rowid
  // ).value;
  // document.getElementById("subcategory-2").value = document.getElementById(
  //   "subcategory2-" + rowid
  // ).value;
}

let removeListBtn = document.getElementsByClassName("remove-listing-btn");

if (removeListBtn.length > 0) {
  for (let i = 0; i < removeListBtn.length; i++) {
    removeListBtn[i].addEventListener("click", function () {
      let itemID = this.getAttribute("data-id");
      document.getElementById("delete-listing").value = itemID;
    });
  }
}