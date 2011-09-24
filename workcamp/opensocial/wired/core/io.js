/*
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

var gadgets = gadgets || {};

/**
 * @fileoverview Provides remote content retrieval facilities.
 *     Available to every gadget.
 */

/**
 * @static
 * @class Provides remote content retrieval functions.
 * @name gadgets.io
 */

gadgets.io = function() {
  return /** @scope gadgets.io */ {
    /**
   * Fetches content from the provided URL and feeds that content into the
   * callback function.
   *
   * Example:
   * <pre>
   * gadgets.io.makeRequest(url, fn,
   *    {contentType: gadgets.io.ContentType.FEED});
   * </pre>
   *
   * @param {String} url The URL where the content is located
   * @param {Function} callback The function to call with the data from the
   *     URL once it is fetched
   * @param {Map.&lt;gadgets.io.RequestParameters, Object&gt;} opt_params
   *     Additional
   *     <a href="gadgets.io.RequestParameters.html">parameters</a>
   *     to pass to the request
   */
    makeRequest : function (url, callback, opt_params) {},

    /**
   * Converts an input object into a url encoded data string (key=value&...)
   *
   * @param {Object} fields The post fields you wish to encode
   * @return {String} The processed post data. This will include a trialing
   *    ampersand (&).
   */
    encodeValues : function (fields) {},

    /**
   * Gets the proxy version of the passed in url.
   *
   * @param {String} url The url to get the proxy url for.
   * @return {String} The proxied version of the url.
   */
    getProxyUrl : function (url) {}
  };
}();


/**
 * @static
 * @class
 * Used by the
 * <a href="gadgets.io.html#makeRequest">
 * <code>gadgets.io.makeRequest()</code></a> method.
 * @name gadgets.io.RequestParameters
 */
gadgets.io.RequestParameters = {
  /**
   * The method to use when fetching content from the URL;
   * defaults to <code>MethodType.GET</a></code>.
   * Specified as a
   * <a href="gadgets.io.MethodType.html">MethodType</a>.
   */
   METHOD : 'METHOD',

  /**
   * The type of content that lives at the URL;
   * defaults to <code>ContentType.HTML</code>.
   * Specified as a
   * <a href="gadgets.io.ContentType.html">
   * ContentType</a>.
   */
  CONTENT_TYPE : "CONTENT_TYPE",

  /**
   * The data to send to the URL using the POST method.
   * Specified as a <code>String</code>
   * Defaults to null.
   */
  POST_DATA : "POST_DATA",

  /**
   * The HTTP headers to send to the URL.
   * Specified as a <code>Map.<String,String></code>
   * Defaults to null.
   */
  HEADERS : "HEADERS",

  /**
   * The type of authentication to use when fetching the content;
   * defaults to <code>AuthorizationType.NONE</code>.
   * Specified as an
   * <a href="gadgets.io.AuthorizationType.html">
   * AuthorizationType</a>.
   */
  AUTHORIZATION : 'AUTHORIZATION',


  /**
   * If the content is a feed, the number of entries to fetch;
   * defaults to 3.
   * Specified as a <code>Number</code>.
   */
  NUM_ENTRIES : 'NUM_ENTRIES',

  /**
   * If the content is a feed, whether to fetch summaries for that feed;
   * defaults to false.
   * Specified as a <code>Boolean</code>.
   */
  GET_SUMMARIES : 'GET_SUMMARIES'
};


/**
 * @static
 * @class
 * Used by
 * <a href="gadgets.io.RequestParameters.html">
 * RequestParameters</a>.
 * @name gadgets.io.MethodType
 */
gadgets.io.MethodType = {
  /** The default type. */
  GET : 'GET',

  /**
  * Not supported by all containers.
  */
  POST : 'POST',

  /**
  * Not supported by all containers.
  */
  PUT : 'PUT',

  /**
  * Not supported by all containers.
  */
  DELETE : 'DELETE',

  /**
   * Not supported by all containers.
   */
  HEAD : 'HEAD'
};


/**
 * @static
 * @class
 * Used by
 * <a href="gadgets.io.RequestParameters.html">
 * RequestParameters</a>.
 * @name gadgets.io.ContentType
 */
gadgets.io.ContentType = {
  /**
   * Returns text, used for fetching html.
   */
  TEXT : 'TEXT',

  /**
   * Returns a dom object, used for fetching xml.
   */
  DOM : 'DOM',

  /**
   * Returns a json object.
   */
  JSON : 'JSON',

  /**
   * Returns a json representation of a feed.
   */
  FEED : 'FEED'
};


/**
 * @static
 * @class
 * Used by
 * <a href="gadgets.io.RequestParameters.html">
 * RequestParameters</a>.
 * @name gadgets.io.AuthorizationType
 */
gadgets.io.AuthorizationType = {
  /** No authorization */
  NONE : 'NONE',

  /** The request will be signed by the container */
  SIGNED : 'SIGNED',

  /** The container will use full authentication */
  AUTHENTICATED : 'AUTHENTICATED'
};
