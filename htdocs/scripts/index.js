// Imports
import { Endpoint } from "./endpoint.js";

// Initialize the endpoint
const endpoint = new Endpoint();

// Base url for Cloudinary
const cloudinaryBase =
  "https://res.cloudinary.com/dqg3qyjio/image/upload/v1674841639/3512-2023-01-project-images/";

// Select the div where the data will be displayed.
let div = document.querySelector("#country_list");

async function getCountryList() {
  // Create the endpoint
  let countryEndpoint = endpoint.for({});

  // Fetch the data from the API.
  let response = await fetch(countryEndpoint);

  // Parse the response as JSON.
  let countryList = await response.json();

  // Save the country list to local storage.
  // TODO: UNCOMMENT THIS LINE BEFORE SUBMITTING
  localStorage.setItem("countryList", JSON.stringify(countryList));

  return countryList;
}

async function getCityList(iso) {
  // Create the endpoint
  let cityEndpoint = endpoint.for({ iso: iso });

  // Fetch the data from the API.
  let response = await fetch(cityEndpoint);

  // Parse the response as JSON.
  let cityList = await response.json();

  return cityList;
}

async function getCountryInfo(iso) {
  // Create the endpoint
  let countryInfoEndpoint = endpoint.for({ infoISO: iso });

  // Fetch the data from the API.
  let response = await fetch(countryInfoEndpoint);

  // Parse the response as JSON.
  let countryInfo = await response.json();

  return countryInfo;
}

async function getRating(imageId) {
  // Create the endpoint
  let ratingEndpoint = endpoint.for({ imageId: imageId });

  // Fetch the data from the API.
  let response = await fetch(ratingEndpoint);

  // Parse the response as JSON.
  let rating = await response.json();

  return rating;
}

async function getLanguages() {
  // Create the endpoint
  let languagesEndpoint = endpoint.for({ languages: true });

  // Fetch the data from the API.
  let response = await fetch(languagesEndpoint);

  // Parse the response as JSON.
  let languages = await response.json();

  return languages;
}

function displayCountries(countryList) {
  // Create a new array to hold only unique countries
  let uniqueCountries = [];

  // Loop through the data and add unique countries to the new array
  for (let country of countryList.countries) {
    // 👇 Helped by AI
    // .some returns true if the element is found in the array
    let isUnique = !uniqueCountries.some(
      (c) => c.CountryName === country.CountryName
    );

    // If the country is unique, add it to the array.
    if (isUnique) {
      uniqueCountries.push(country);
    }
  }

  // Clear any existing data.
  div.replaceChildren();

  // Loop through the unique country data and display it as an accordion.
  for (let country of uniqueCountries) {
    // Create the elements that will be used to display the data.
    let details = document.createElement("details");
    let summary = document.createElement("summary");

    // Add the necessary data to the Summary element.
    summary.textContent = country.CountryName;
    summary.setAttribute("data-iso", country.ISO);

    // Check if the country has a Path and ImageID.
    if (country.Path !== null || country.ImageID !== null) {
      summary.setAttribute("data-has-image", true);
      summary.setAttribute("data-path", country.Path);
    }

    // Append the accordion to the div.
    details.append(summary);
    div.append(details);
  }
}

function filterCountries(search) {
  // Get the current country list and the search value.
  let currentCountryList = document.querySelector("#country_list");
  let searchValue = search.target.value.toLowerCase();

  // Loop through the country list and remove the countries that don't match the search value.
  for (let country of currentCountryList.children) {
    if (!country.textContent.toLowerCase().startsWith(searchValue)) {
      country.style.display = "none";
    } else {
      country.style.display = "block";
    }
  }

  // If the search value is empty, display all the countries.
  if (searchValue === "") {
    for (let country of currentCountryList.children) {
      country.style.display = "block";
    }
  }
}

async function handleCountryClick(event) {
  // Handle the click event on the summary element (Country Name).
  if (event.target.nodeName === "SUMMARY") {
    // Display country info and city list.
    displayCountryInfo(event);
    displayCities(event);
  }

  // Handle the click event on the li element (City Name).
  if (event.target.nodeName === "LI") {
    if (event.target.textContent === "No cities found.") {
      return;
    }
    // Display city info.
    displayCityInfo(event);
  }
}

async function displayCityInfo(event) {
  // Get the city name from the li element.
  let cityName = event.target.textContent;

  // Get the country ISO from the summary element.
  let countryISO = event.target.parentElement.parentElement
    .querySelector("summary")
    .getAttribute("data-iso");

  // Get the country name from the summary element.
  let countryName =
    event.target.parentElement.parentElement.querySelector(
      "summary"
    ).textContent;

  // Get the city info from the API.
  let cityInfo = await getCityList(countryISO);

  // Select where the data will be displayed.
  let cityInfoArticle = document.querySelector("#country_info");

  // Clear the city info
  cityInfoArticle.replaceChildren();

  // Get necessary data from the city info.
  let populationText = "";
  let elevationText = "";
  let timezoneText = "";
  let imgPath = "";

  // Check the city info to see get the population, elevation, and timezone.
  for (let city of cityInfo.cities) {
    if (city.CityName === cityName) {
      populationText = city.Population.toLocaleString();
      elevationText = city.Elevation.toLocaleString();
      timezoneText = city.TimeZone;
      imgPath = city.Path;
    }
  }

  // Create the content that will go in the header of the article.
  let header = document.createElement("header");
  let img = document.createElement("img");

  // Check if the imgPath is null
  if (imgPath === null) {
    let noImg = document.createElement("h2");
    noImg.textContent = "No image found.";
    noImg.classList.add("no-image");
    header.append(noImg);
  } else {
    img.src = cloudinaryBase + imgPath;
    img.alt = "Image from " + cityName;
    img.classList.add("change_on_hover");
    header.append(img);
  }

  // Create the content that will go in the main of the article.
  let hgroup = document.createElement("hgroup");
  let h2 = document.createElement("h2");
  let h3 = document.createElement("h3");

  // Set the content of the main.
  h2.textContent = cityName;
  h3.textContent = countryName;

  // Append the content to the article.
  hgroup.append(h2, h3);

  // Create the content that will go in the footer of the article.
  let footer = document.createElement("footer");
  let pouplation = document.createElement("p");
  let elevation = document.createElement("p");
  let timezone = document.createElement("p");

  // Set the content of the footer.
  pouplation.textContent = `Population: ${populationText} people`;
  elevation.textContent = `Elevation: ${elevationText} meters`;
  timezone.textContent = `Timezone: ${timezoneText}`;

  // Append the content to the article.
  footer.append(pouplation, elevation, timezone);

  // Append the content to the article.
  cityInfoArticle.append(header, hgroup, footer);
}

// Note for JP: I am not prouf of this but it works (mostly).
// I know this function should be boken up into a million more
async function displayCountryInfo(event) {
  // Get the ISO code from the summary.
  let iso = event.target.getAttribute("data-iso");

  // Get the country info from the API.
  let countryInfo = await getCountryInfo(iso);
  countryInfo = countryInfo.country_information[0];

  // Select where the data will be displayed.
  let countryInfoArticle = document.querySelector("#country_info");

  // Clear the country info
  countryInfoArticle.replaceChildren();

  // Get the country list from local storage.
  let countryList = JSON.parse(localStorage.getItem("countryList"));

  // Array to hold the image ids.
  let imageIds = [];

  console.log(countryList);

  // Loop through the country list to get the the image ids.
  for (let country of countryList.countries) {
    if (country.ISO === iso) {
      imageIds.push(country.ImageID);
    }
  }

  // Create the content that will go in the header of the article.
  let header = document.createElement("header");
  let noImg = document.createElement("h2");

  // Check if the image id is null.
  if (imageIds[0] === null) {
    noImg.textContent = `Sorry! We have no images for ${countryInfo.CountryName}.`;
    noImg.classList.add("no-image");
    header.append(noImg);
  } else {
    // Get the path for each image id from the country list.
    let imgPaths = imageIds.map((imageId) => {
      let matchingCountry = countryList.countries.find(
        (country) => country.ImageID === imageId
      );
      return matchingCountry ? matchingCountry.Path : null;
    });

    // Create the images for the header.
    let images = imgPaths.map(async (imgPath, index) => {
      let img = document.createElement("img");
      img.src = cloudinaryBase + imgPath;
      img.alt = "Image from " + countryInfo.CountryName;
      img.classList.add("change_on_hover");

      // Get the rating for the corresponding image id from the API.
      let rating = await getRating(imageIds[index]);
      img.setAttribute("data-rating-1-count", rating.ratings[0].rating_1_count);
      img.setAttribute("data-rating-2-count", rating.ratings[0].rating_2_count);
      img.setAttribute("data-rating-3-count", rating.ratings[0].rating_3_count);
      img.setAttribute("data-rating-4-count", rating.ratings[0].rating_4_count);
      img.setAttribute("data-rating-5-count", rating.ratings[0].rating_5_count);
      img.setAttribute("data-image-id", imageIds[index]);
      return img;
    });

    for (let image of images) {
      image = await image;

      console.log(image);

      // Create the table for the ratings.
      let table = document.createElement("table");
      let tableHead = document.createElement("thead");
      let tableBody = document.createElement("tbody");
      let tableRow = document.createElement("tr");
      let tableHead0 = document.createElement("th");
      let tableHead1 = document.createElement("th");
      let tableHead2 = document.createElement("th");
      let tableHead3 = document.createElement("th");
      let tableHead4 = document.createElement("th");
      let tableHead5 = document.createElement("th");
      let tableData0 = document.createElement("td");
      let tableData1 = document.createElement("td");
      let tableData2 = document.createElement("td");
      let tableData3 = document.createElement("td");
      let tableData4 = document.createElement("td");
      let tableData5 = document.createElement("td");

      tableHead0.classList.add("th_center");
      tableHead1.classList.add("th_center");
      tableHead2.classList.add("th_center");
      tableHead3.classList.add("th_center");
      tableHead4.classList.add("th_center");
      tableHead5.classList.add("th_center");
      tableData0.classList.add("th_center");
      tableData1.classList.add("th_center");
      tableData2.classList.add("th_center");
      tableData3.classList.add("th_center");
      tableData4.classList.add("th_center");
      tableData5.classList.add("th_center");

      // Set the content of the table.
      tableHead0.textContent = "Rating";
      tableHead1.textContent = "1⭐";
      tableHead2.textContent = "2⭐";
      tableHead3.textContent = "3⭐";
      tableHead4.textContent = "4⭐";
      tableHead5.textContent = "5⭐";
      tableData0.textContent = "Rated as";
      tableData1.textContent = image.getAttribute("data-rating-1-count");
      tableData2.textContent = image.getAttribute("data-rating-2-count");
      tableData3.textContent = image.getAttribute("data-rating-3-count");
      tableData4.textContent = image.getAttribute("data-rating-4-count");
      tableData5.textContent = image.getAttribute("data-rating-5-count");

      // Append the content to the table.
      tableHead.append(
        tableHead0,
        tableHead1,
        tableHead2,
        tableHead3,
        tableHead4,
        tableHead5
      );
      tableRow.append(
        tableData0,
        tableData1,
        tableData2,
        tableData3,
        tableData4,
        tableData5
      );
      tableBody.append(tableRow);
      table.append(tableHead, tableBody);

      header.append(image, table);
    }

    // Append the images to the header.
    await Promise.all(images).then((images) => {
      images.forEach((image) => header.append(image));
    });
  }

  // Create the content that will go in the main of the article.
  let hgroup = document.createElement("hgroup");
  let h2 = document.createElement("h2");
  let h3 = document.createElement("h3");
  let description = document.createElement("p");

  // Set the content of the main.
  h2.textContent = countryInfo.CountryName;
  h3.textContent = countryInfo.Capital;
  description.textContent = countryInfo.Description;

  // Append the content to the main.
  hgroup.append(h2, h3);

  // Create the content that will go in the footer of the article.
  let footer = document.createElement("footer");
  let languages = document.createElement("p");
  let area = document.createElement("p");
  let population = document.createElement("p");
  let currency = document.createElement("p");
  let neighbours = document.createElement("p");
  let domain = document.createElement("p");

  // Format the data.
  countryInfo.Area = parseInt(countryInfo.Area).toLocaleString();
  countryInfo.Population = parseInt(countryInfo.Population).toLocaleString();
  countryInfo.Languages = await parseLanguages(countryInfo.Languages);
  countryInfo.Neighbours = parseNeighbours(countryInfo.Neighbours);

  // Set the content of the footer.
  languages.textContent = `Languages: ${countryInfo.Languages}`;
  area.textContent = `Area: ${countryInfo.Area} km²`;
  population.textContent = `Population: ${countryInfo.Population} million`;
  currency.textContent = `Currency: ${countryInfo.Currency}`;
  neighbours.textContent = `Neighbours: ${countryInfo.Neighbours}`;
  domain.textContent = `Domain: ${countryInfo.Domain}`;

  // Append the content to the footer.
  footer.append(languages, area, population, currency, neighbours, domain);

  // Append the content to the article.
  countryInfoArticle.append(header, hgroup, description, footer);

  // Display the article.
  countryInfoArticle.style.display = "block";

  // Get the height of the article.
  let articleHeight =
    header.offsetHeight +
    hgroup.offsetHeight +
    description.offsetHeight +
    footer.offsetHeight;

  // Set the height of the country list
  div.style.height = articleHeight + "px";

  // Scroll to the article.
  countryInfoArticle.scrollIntoView();
}

function parseNeighbours(neighbours) {
  let neighboursAsArray = [];

  // check if the neighbours are null
  if (neighbours === null) {
    return "No neighbours.";
  }

  // Check if there is more than one neighbour.
  if (neighbours.includes(",")) {
    // Convert the neighbours string to an array.
    neighboursAsArray = neighbours.split(",");
  }

  // Check if there is only one neighbour.
  if (!neighbours.includes(",")) {
    // Convert the neighbours string to an array.
    neighboursAsArray.push(neighbours);
  }

  // Get the country names from local storage.
  let countryList = JSON.parse(localStorage.getItem("countryList"));

  // Loop through the neighbours array and replace the code with the country name.
  for (let neighbour of neighboursAsArray) {
    let country = countryList.countries.find(
      (country) => country.ISO === neighbour
    );
    if (country) {
      neighboursAsArray[neighboursAsArray.indexOf(neighbour)] =
        country.CountryName;
    }
  }

  // Convert the array to a string.
  neighbours = neighboursAsArray.join(", ");

  return neighbours;
}

async function parseLanguages(languages) {
  // Convert the languages string to an array.
  let languagesAsArray = languages.split(",");

  // Loop through the array and remove text after the dash.
  languagesAsArray = languagesAsArray.map(function (str) {
    return str.split("-")[0];
  });

  let languageList;

  // Check if the languageList is in local storage.
  if (!localStorage.getItem("languages")) {
    // Get the language list from the API.
    languageList = await getLanguages();

    // Save the language list to local storage.
    // TODO: UNCOMMENT THIS LINE BEFORE SUBMITTING
    localStorage.setItem("languages", JSON.stringify(languageList));
  } else {
    // Get the language list from local storage.
    languageList = JSON.parse(localStorage.getItem("languages"));
  }

  // Loop through the language list and replace the code with the language name.
  for (let language of languagesAsArray) {
    let lang = languageList.languages.find((lang) => lang.iso === language);
    if (lang) {
      languagesAsArray[languagesAsArray.indexOf(language)] = lang.name;
    } else {
      let index = languagesAsArray.indexOf(language);
      if (index !== -1) {
        languagesAsArray.splice(index, 1);
      }
    }
  }

  // Convert the array to a string.
  languages = languagesAsArray.join(", ");

  return languages;
}

async function displayCities(event) {
  // Get the ISO code from the summary.
  let iso = event.target.getAttribute("data-iso");

  // Get the city list from the API.
  let cityList = await getCityList(iso);

  // Select the accordion where the data will be displayed.
  let accordion = event.target.parentElement;

  // loop through the accordion and remove the city list.
  for (let child of accordion.children) {
    if (child.nodeName === "UL") {
      child.remove();
    }
  }

  // Create a list to display the cities.
  let cityListElement = document.createElement("ul");

  // Loop through the city list and display the cities.
  for (let city of cityList.cities) {
    let li = document.createElement("li");
    li.textContent = city.CityName;
    cityListElement.append(li);
  }

  // If there are no cities, display a message.
  if (cityList.cities.length === 0) {
    let li = document.createElement("li");
    li.textContent = "No cities found.";
    cityListElement.append(li);
  }

  // Append the city list to the accordion.
  accordion.append(cityListElement);
}

function hideCountriesWithoutImages() {
  // return if checkbox is not checked
  if (!document.querySelector("#images_only").checked) {
    // Show all the countries.
    for (let country of currentCountryList.children) {
      country.style.display = "block";
    }
    return;
  }

  // Hide the countries without images.
  let countryList = document.querySelector("#country_list");

  for (let country of countryList.children) {
    // data-has-image is on the summary element
    let summary = country.children[0];

    // check if the country has the data-has-image attribute
    if (!summary.hasAttribute("data-has-image")) {
      country.style.display = "none";
    }
  }
}

// Check if the country list is in local storage.
if (localStorage.getItem("countryList")) {
  // If it is, display the countries.
  let countryList = JSON.parse(localStorage.getItem("countryList"));
  displayCountries(countryList);
} else {
  // If it isn't, get the country list from the API.
  let countryList = await getCountryList();
  displayCountries(countryList);
}

// Filter the countries when the user types in the search box.
let search = document.querySelector("#country_search");
search.addEventListener("keyup", filterCountries);

// Call the handleCountryClick function when a summary is clicked.
let currentCountryList = document.querySelector("#country_list");
currentCountryList.addEventListener("click", handleCountryClick);

let imagesOnly = document.querySelector("#images_only");
imagesOnly.addEventListener("change", hideCountriesWithoutImages);
