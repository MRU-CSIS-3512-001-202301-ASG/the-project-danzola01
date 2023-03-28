function Endpoint() {
  //   Define the base URL.
  this.base = "http://127.0.0.1/api/posts.php";

  //   Define the for() method.
  this.for = function (context) {
    // If context is empty, use the base URL.
    if (Object.keys(context).length === 0) {
      return this.base;
    }

    // if there is a country, add it to the URL.
    if (context.country) {
      return this.base + "?country=" + context.country;
    }

    // if the iso is set, add it to the URL.
    if (context.iso) {
      return this.base + "?countryISO=" + context.iso;
    }
  };
}

export { Endpoint };
