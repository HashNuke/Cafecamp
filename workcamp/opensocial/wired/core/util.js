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
 * @fileoverview General purpose utilities that gadgets can use.
 */

/**
 * @static
 * @class Provides general purpose utility functions.
 * @name gadgets.util
 */

gadgets.util = function() {
  return /** @scope gadgets.util */ {

    /**
     * Gets the url parameters.
     *
     * @return {Object} Parameters passed into the query string.
     */
    getUrlParameters : function () {},

  /**
     * Creates a closure which is suitable for passing as a callback.
     *
     * @param {Object} scope The execution scope. May be null if there is no
     *     need to associate a specific instance of an object with this
     *     callback.
     * @param {Function} callback The callback to invoke when this is run.
     *     any arguments passed in will be passed after your initial arguments.
     * @param {Object} var_args Any number of arguments may be passed to the
     *     callback. They will be received in the order they are passed in.
     */
    makeClosure : function (scope, callback, var_args) {},

  /**
     * Gets the feature parameters.
     *
     * @param {String} feature The feature to get parameters for.
     * @return {Object} The parameters for the given feature, or null.
     */
    getFeatureParameters : function (feature) {},

  /**
     * Returns whether the current feature is supported.
     *
     * @param {String} feature The feature to test for.
     * @return {Boolean} True if the feature is supported.
     */
    hasFeature : function (feature) {},

  /**
     * Registers an onload handler.
     * @param {Function} callback The handler to run.
     */
    registerOnLoadHandler : function (callback) {}
  };
}();
