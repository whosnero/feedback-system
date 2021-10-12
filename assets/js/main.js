function date() {
  fyear = new Date().getYear();
  year = fyear < 1900 ? (fyear += 1900) : fyear;
  buildyear = 2021;
  return year > buildyear
    ? "&copy " + buildyear + " - " + year
    : "&copy " + buildyear;
}
