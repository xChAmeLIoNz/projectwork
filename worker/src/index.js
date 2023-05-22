/**
 * Welcome to Cloudflare Workers! This is your first worker.
 *
 * - Run `npx wrangler dev src/index.js` in your terminal to start a development server
 * - Open a browser tab at http://localhost:8787/ to see your worker in action
 * - Run `npx wrangler publish src/index.js --name my-worker` to publish your worker
 *
 * Learn more at https://developers.cloudflare.com/workers/
 */

export default {
	async fetch(request, env, ctx) {
	  const responseData = { message: 'Hello from Cloudflare Worker!' };
	  
	  // Create a new Response object with the desired response body
	  const response = new Response(JSON.stringify(responseData));
	  
	  // Add the necessary CORS headers
	  response.headers.set('Access-Control-Allow-Origin', 'https://iseppe.it');
	  response.headers.set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
	  response.headers.set('Access-Control-Allow-Headers', 'Content-Type');
	  
	  return response;
	},
  };
  
