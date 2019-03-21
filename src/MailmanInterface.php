<?php

namespace himito\mailman;

interface MailmanInterface
{
  /**
   * List the members of a list
   *
   * @param string $list_id id of the list
   * @return array
   */
  public function members($list_id);

  /**
   *  List all the mailing lists
   *
   * @return array
   */
  public function lists();

  /**
   * Creates a new mailing list
   *
   * @param string $name email of the mailing list
   * @return bool
   */
  public function create_list($name);

  /**
   * Updates the options of a list
   *
   * @param string $list email of the list
   * @param array $options array with the new values
   * @return bool
   */
  public function update_list($list, $options);

  /**
   * Removes a mailing list
   *
   * @param sting $name name of the mailing list
   * @return bool
   */
  public function remove_list($name);

  /**
   * Subscribes a user to a list
   *
   * @param string $list_id id of the list
   * @param string $user_name full name of the user
   * @param string $user_email email of the user
   * @return bool
   */
  public function subscribe($list_id, $user_name, $user_email);

  /**
   * Unsubscribes a user from a list
   *
   * @param string $list_id id of the list
   * @param string $user_email email of the user
   * @return bool
   */
  public function unsubscribe($list_id, $user_email);

  /**
   * Returns all the lists where the member is member
   *
   * @param string $user email of the user
   * @return array
   */
  public function membership($user);
}
