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

function setToEdit(thisElement) {
  let rowid = thisElement.value;
  document.getElementById("edit-item-title").value = document.getElementById(
    "title-" + rowid
  ).value;
  document.getElementById("edit-item-price").value = document.getElementById(
    "price-" + rowid
  ).value;
  document.getElementById("edit-item-condition").value =
    document.getElementById("item_condition-" + rowid).value;
  document.getElementById("edit-item-description").value =
    document.getElementById("item_description-" + rowid).value;
  document.getElementById("id-placeholder-row2").value = thisElement.value;
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

let relistListBtn = document.getElementsByClassName("relist-item-btn");

if (relistListBtn.length > 0) {
  for (let i = 0; i < relistListBtn.length; i++) {
    relistListBtn[i].addEventListener("click", function () {
      let itemID = this.getAttribute("data-id");
      document.getElementById("relist-listing").value = itemID;
    });
  }
}

let acceptOfferBtn = document.getElementsByClassName("accept-offer-btn");

if (acceptOfferBtn.length > 0) {
  for (let i = 0; i < acceptOfferBtn.length; i++) {
    acceptOfferBtn[i].addEventListener("click", function () {
      let itemID = this.getAttribute("data-id");
      let userID = this.getAttribute("data-id2");
      document.getElementById("accept-offer").value = itemID;
      document.getElementById("accept-offer-user").value = userID;
    });
  }
}

let declineOfferBtn = document.getElementsByClassName("decline-offer-btn");

if (declineOfferBtn.length > 0) {
  for (let i = 0; i < declineOfferBtn.length; i++) {
    declineOfferBtn[i].addEventListener("click", function () {
      let itemID = this.getAttribute("data-id");
      let userID = this.getAttribute("data-id2");
      document.getElementById("decline-offer").value = itemID;
      document.getElementById("decline-offer-user").value = userID;
    });
  }
}
