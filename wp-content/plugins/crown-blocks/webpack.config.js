/**
 * `@wordpress/scripts` multi-config multi-block Webpack configuration.
 * @see https://wordpress.stackexchange.com/questions/390282
 */

// Native Depedencies.
const path = require( 'path' );
const fs = require( 'fs' );

const default_config_path = require.resolve( '@wordpress/scripts/config/webpack.config.js' );

/**
 * Retrieves a new instance of `@wordpress/scripts`' default webpack configuration object.
 * @returns WebpackOptions
 */
const getBaseConfig = () => {
  // If the default config's already been imported, clear the module from the cache so that Node
  // will interpret the module file again and provide a brand new object.
  if( require.cache[ default_config_path ] )
    delete require.cache[ default_config_path ];

  // Import a new instance of the default configuration object.
  return require( default_config_path );
};

/**
 * @callback buildConfig~callback
 * @param {WebpackOptions} config An instance of `@wordpress/scripts`' default configuration object.
 * @returns WebpackOptions The modified or replaced configuration object.
 */

/**
 * Returns the result of executing a callback function provided with a new default configuration
 * instance.
 *
 * @param {buildConfig~callback} callback
 * @returns WebpackOptions The modified or replaced configuration object.
 */
const buildConfig = ( callback ) => callback( getBaseConfig() );

/**
 * Extends `@wordpress/scripts`'s default webpack config to build block sources from a common
 * `./src/blocks` directory and output built assets to a common build directory.
 * 
 * @param {string} block_name 
 * @returns WebpackOptions A configuration object for this block.
 */
const buildBlockConfig = ( block_name ) => buildConfig(
  config => (
    { // Copy all properties from the base config into the new config, then override some.
      ...config,
      // Override the block's "index" entry point to be `./blocks/{block name}/src/index.js`.
      entry: {
        index: path.resolve( process.cwd(), 'blocks', block_name, 'src', 'index.js' ),
        public: path.resolve( process.cwd(), 'blocks', block_name, 'src', 'public.js' ),
      },
      // This block's built assets should be output to `./blocks/{block name}/build/`.
      output: {
        ...config.output,
        filename: '[name].js',
        path: path.resolve( process.cwd(), 'blocks', block_name, 'build' ),
      },
    }
  )
);

let blockConfigs = [];

// Get blocks directory
const directoryPath = path.join(__dirname, 'blocks');

// Get names of individual block directories
fs.readdirSync(directoryPath).forEach(file => {
    if ( !file.startsWith('.') && !file.startsWith('_') ) {
        blockConfigs.push( buildBlockConfig( file ) );
    }
});

module.exports = blockConfigs;
