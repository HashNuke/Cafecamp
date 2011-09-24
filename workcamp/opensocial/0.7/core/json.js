/*
Copyright (c) 2005 JSON.org

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The Software shall be used for Good, not Evil.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

/**
 * @fileoverview
 * The global object gadgets.json contains two methods.
 *
 * gadgets.json.stringify(value) takes a JavaScript value and produces a JSON
 * text. The value must not be cyclical.
 *
 * gadgets.json.parse(text) takes a JSON text and produces a JavaScript value.
 * It will return false if there is an error.
*/

var gadgets = gadgets || {};

/**
 * @static
 * @class Provides operations for translating objects to and from JSON.
 * @name gadgets.json
 */

/**
 * @scope gadgets.json
 */
gadgets.json = function () {
  return {
    /**
   * Stringifies a JavaScript value, producing a JSON text.
   *
   * @param {Object} v The object to stringify.
   * @return {String} The stringified object.
   */
    stringify: function (v) {},

    /**
   * Parses a JSON text, producing a JavaScript value.
   * It returns false if there is a syntax error.
   *
   * @param {String} text The string to transform into an object. Usually
   *     the result of a previous stringify call.
   * @return {Object} The object parsed from the passed in text. False if
   *     an error occurred.
   */
    parse: function (text) {}
  }
}();


