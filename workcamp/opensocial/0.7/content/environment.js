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

/**
 * @fileoverview Representation of a environment.
 */


/**
 * @class
 * Represents the current environment for a gadget.
 *
 * <p>
 * <b>See also:</b>
 * <a href="opensocial.html#getEnvironment">opensocial.getEnvironment()</a>,
 *
 * @name opensocial.Environment
 */


/**
 * Base interface for all environment objects.
 *
 * @param {String} domain The current domain
 * @param {opensocial.Surface} surface The current surface
 * @param {Array.&lt;Surface&gt;} supportedSurfaces
 *    The surfaces supported by this container
 * @param {Map.&lt;String, Map.&lt;String, Boolean&gt;&gt;} supportedFields
 *    The fields supported by this container
 * @param {Map.&lt;String, String&gt;} opt_params
 *    The params this gadget has access to
 *
 * @private
 * @constructor
 */
opensocial.Environment = function() {};


/**
 * Returns the current domain &mdash;
 * for example, "orkut.com" or "myspace.com".
 *
 * @return {String} The domain
 */
opensocial.Environment.prototype.getDomain = function() {};


/**
 * @static
 * @class
 *
 * The types of objects in this container.
 *
 * <p>
 * <b>See also:</b>
 * <a href="opensocial.Environment.html#supportsField">
 * <code>Environment.supportsField()</code></a>
 *
 * @name opensocial.Environment.ObjectType
 */
opensocial.Environment.ObjectType = {
  /**
   * @member opensocial.Environment.ObjectType
   */
  PERSON : 'person',
  /**
   * @member opensocial.Environment.ObjectType
   */
  ADDRESS : 'address',
  /**
   * @member opensocial.Environment.ObjectType
   */
  BODY_TYPE : 'bodyType',
  /**
   * @member opensocial.Environment.ObjectType
   */
  EMAIL : 'email',
  /**
   * @member opensocial.Environment.ObjectType
   */
  NAME : 'name',
  /**
   * @member opensocial.Environment.ObjectType
   */
  ORGANIZATION : 'organization',
  /**
   * @member opensocial.Environment.ObjectType
   */
  PHONE : 'phone',
  /**
   * @member opensocial.Environment.ObjectType
   */
  URL : 'url',
  /**
   * @member opensocial.Environment.ObjectType
   */
  ACTIVITY : 'activity',
  /**
   * @member opensocial.Environment.ObjectType
   */
  ACTIVITY_MEDIA_ITEM : 'activityMediaItem',
  /**
   * @member opensocial.Environment.ObjectType
   */
  MESSAGE : 'message',
  /**
   * @member opensocial.Environment.ObjectType
   */
  MESSAGE_TYPE : 'messageType',
  /**
   * @member opensocial.Environment.ObjectType
   */
  SORT_ORDER : 'sortOrder',
  /**
   * @member opensocial.Environment.ObjectType
   */
  FILTER_TYPE : 'filterType'
};


/**
 * Returns true if the specified field is supported in this container on the
 * given object type.
 *
 * @param {opensocial.Environment.ObjectType} objectType
 *    The <a href="opensocial.Environment.ObjectType.html">object type</a>
 *    to check for the field
 * @param {String} fieldName The name of the field to check for
 * @return {Boolean} True if the field is supported on the specified object type
 */
opensocial.Environment.prototype.supportsField = function(objectType,
    fieldName) {};