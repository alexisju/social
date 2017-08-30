## Social share plugin for Shaarli

For each link in your Shaarli, this plugin adds links to share your bookmarks to main social networks and by email (mailto).

### Installation/configuration

Clone this repository inside your `plugins/` directory, or download the archive and unpack it there.  
The directory structure should look like:

```
└── plugins
        └── social
            ├── README.md
            ├── social.php
            ├── social.html
            └── social.css
```

To enable the plugin, just check it in the plugin administration page.

You can also add `social` to your list of enabled plugins in `data/config.json.php`
(`general.enabled_plugins` list).

This should look like:

```
"general": {
  "enabled_plugins": [
    "social",
    [...]
  ],
}
```
### Demo

 - http://liens.effingo.be
