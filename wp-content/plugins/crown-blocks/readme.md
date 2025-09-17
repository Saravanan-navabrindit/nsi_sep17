# Crown Blocks Framework

Crown Blocks provides a framework for creating multiple custom WordPress blocks in a single plugin. 

## Installation

In the crown-blocks plugin directory from terminal, install all the required node modules:

```
$ npm install
```

## Usage

Watch all files for changes and rebuild assets (scss and js):

```
$ npm start
```

Build/rebuild all block assets once:

```
$ npm run build
```

## FAQ


#### How do I edit a block's settings? 

Crown Blocks reads the settings array in the 'block.json' file in the root of a block directory. 


#### How do I load files from a new block? 

Crown Blocks scans the 'blocks' directory and auto-loads all blocks. 


#### How do I remove a block? 

Just delete the entire block directory inside the 'blocks' directory. 


#### Are blocks self-contained units? 

Yes, Crown Blocks is a modular system that allows for adding and removing blocks without having to specify which ones you want to load. 


#### How do I disable a block without deleting it then? 

All block directories starting with "_" (underscore) will be ignored. 


#### Will a block's CSS and JavaScript only load if it's being used on the page?

Yes! Crown Blocks' utilization of 'block.json' for block settings allows for lazy-loading of block assets. 


#### How do I add JavaScript that only runs on the front-end?

Edit the public.js file in a block's 'src' directory and add your scripts in there. 
