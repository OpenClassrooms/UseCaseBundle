{ pkgs, lib, config, ... }:

let
  profile = ".devenv/profile";
  composerJson = builtins.fromJSON (builtins.readFile ./composer.json);
  requiredPackages = builtins.attrNames composerJson.require;
  phpExtensionsDirty = builtins.filter
    (name:
      builtins.match "ext-.*" name != null &&
      !builtins.elem (builtins.substring 4 100 name) [ "json" "libxml" "xml" ]
    )
    requiredPackages;
  phpExtensions = builtins.map (name: builtins.replaceStrings [ "ext-" ] [ "" ] name) phpExtensionsDirty;
in
{
  languages.php = {
    enable = true;
    version = lib.mkDefault "8.2";
    extensions = phpExtensions ++ [ "xdebug" ];
  };

}
