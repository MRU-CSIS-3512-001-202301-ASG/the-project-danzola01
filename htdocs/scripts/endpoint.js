function Endpoint() {
  //   Define the base URL.
  this.base = "http://127.0.0.1/api/";

  //   Define the for() method.
  this.for = function (context) {
    // If context is empty, use the base URL.
    if (Object.keys(context).length === 0) {
      return this.base + "posts.php";
    }

    // if there is a country, add it to the URL.
    if (context.country) {
      return this.base + "posts.php?country=" + context.country;
    }

    // if the iso is set, add it to the URL.
    if (context.iso) {
      return this.base + "posts.php?countryISO=" + context.iso;
    }

    if (context.infoISO) {
      return this.base + "countryInformation.php?countryISO=" + context.infoISO;
    }

    if (context.languages) {
      return this.base + "languages.php";
    }

    if (context.imageId) {
      return this.base + "ratings.php?imageId=" + context.imageId;
    }

    if (context.infoForId) {
      return this.base + "photoInformation.php?imageId=" + context.infoForId;
    }

    if (context.ratingInfo) {
      return this.base + "ratingInformation.php?imageId=" + context.ratingInfo;
    }
  };
}

export { Endpoint };
