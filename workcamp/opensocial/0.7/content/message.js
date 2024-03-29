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
 * @fileoverview Representation of a message.
 */


/**
 * @class
 * Base interface for all message objects.
 *
 * <p>
 * <b>See also:</b>
 * <a href="opensocial.html#newMessage">opensocial.newMessage()</a>,
 * <a href="opensocial.html#requestSendMessage">
 * opensocial.requestSendMessage()</a>
 *
 * @name opensocial.Message
 */


/**
 * Base interface for all message objects.
 *
 * @param {String} body The main text of the message.
 * @param {Map.<opensocial.Message.Field, Object>} opt_params Any other
 *    fields that should be set on the message object. All of the defined
 *    Fields are supported.
 * @private
 * @constructor
 */
opensocial.Message = function() {};


/**
 * @static
 * @class
 * All of the fields that messages can have.
 *
 * <p>
 * <b>See also:</b>
 * <a
 * href="opensocial.Message.html#getField">opensocial.Message.getField()</a>
 * </p>
 *
 * @name opensocial.Message.Field
 */
opensocial.Message.Field = {
  /**
   * The title of the message, specified as an opensocial.Message.Type.
   * @member opensocial.Message.Field
   */
  TYPE : 'type',

  /**
   * The title of the message. Html attributes are allowed and will be
   * sanitized by the container.
   * @member opensocial.Message.Field
   */
  TITLE : 'title',

  /**
   * The main text of the message. Html attributes are allowed and will be
   * sanitized by the container.
   * @member opensocial.Message.Field
   */
  BODY : 'body'
};


/**
 * @static
 * @class
 * The types of messages that can be sent.
 *
 * @name opensocial.Message.Type
 */
opensocial.Message.Type = {
  /**
   * An email.
   */
  EMAIL : 'email',

  /**
   * A short private message.
   */
  NOTIFICATION : 'notification',

  /**
   * A message to a specific user that can be seen by more than that user.
   */
  PRIVATE_MESSAGE : 'privateMessage',

  /**
   * A message to a specific user that can be seen by only that user.
   */
  PUBLIC_MESSAGE : 'publicMessage'
};


/**
 * Gets the message data that's associated with the specified key.
 *
 * @param {String} key The key to get data for;
 *   see the <a href="opensocial.Message.Field.html">Field</a> class
 * for possible values
 * @return {String} The data
 * @member opensocial.Message
 */
opensocial.Message.prototype.getField = function(key) {};


/**
 * Sets data for this message associated with the given key.
 *
 * @param {String} key The key to set data for
 * @param {String} data The data to set
 */
opensocial.Message.prototype.setField = function(key, data) {};
