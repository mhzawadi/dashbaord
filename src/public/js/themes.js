function set_root(colour1, colour2, colour3){
  document.body.style.setProperty("--color-primary", colour2);
  document.body.style.setProperty("--color-accent", colour3);
  document.body.style.setProperty("--color-background", colour1);
  sendData({ defaultTheme: colour2 + ";" + colour3 + ";" + colour1}, "/settings/defaultTheme/edit");
}

function edit_theme(id, name, background, primary, accent){
  document.getElementById("name").value = name;
  document.getElementById("themeID").value = id;
  document.getElementById("background").value = background;
  document.getElementById("primary").value = primary;
  document.getElementById("accent").value = accent;
  document.getElementById("btn_theme").textContent = "Update Theme";
  openModal("ThemeModal");
}
