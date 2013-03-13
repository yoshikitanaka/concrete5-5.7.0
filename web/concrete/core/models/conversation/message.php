<?
defined('C5_EXECUTE') or die("Access Denied.");
class Concrete5_Model_Conversation_Message extends Object {

	public function getConversationMessageID() {return $this->cnvMessageID;}
	public function getConversationMessageSubject() {return $this->cnvMessageSubject;}
	public function getConversationMessageBody() {return $this->cnvMessageBody;}
	public function getConversationID() {return $this->cnvID;}
	public function getConversationMessageLevel() {return $this->cnvMessageLevel;}
	public function getConversationMessageParentID() {return $this->cnvMessageParentID;}
	public function isConversationMessageDeleted() {return $this->cnvIsMessageDeleted;}
	public function getConversationMessageBodyOutput() {
		if ($this->cnvIsMessageDeleted) {
			return t('This message has been deleted.');
		} else {
			$editor = ConversationEditor::getActive();
			return $editor->formatConversationMessageBody($this->cnvMessageBody);
		}
	}
	public function getConversationMessageUserObject() {
		return UserInfo::getByID($this->uID);
	}
	public function getConversationMessageUserID() {
		return $this->uID;
	}
	public function getConversationMessageDateTime() {
		return $this->cnvMessageDateCreated;
	}
	public function getConversationMessageDateTimeOutput() {
		return t('Posted on %s', Loader::helper('date')->date('F d, Y \a\t g:i a', strtotime($this->cnvMessageDateCreated)));
	}

	public static function getByID($cnvMessageID) {
		$db = Loader::db();
		$r = $db->GetRow('select * from ConversationMessages where cnvMessageID = ?', array($cnvMessageID));
		if (is_array($r) && $r['cnvMessageID'] == $cnvMessageID) {
			$cnv = new ConversationMessage;
			$cnv->setPropertiesFromArray($r);
			return $cnv;
		}
	}

	public function delete() {
		$db = Loader::db();
		$db->Execute('update ConversationMessages set uID = ?, cnvMessageSubject = null, cnvMessageBody = null, cnvIsMessageDeleted = 1 where cnvMessageID = ?', array(
			USER_DELETED_CONVERSATION_ID,
			$this->cnvMessageID
		));

		$this->cnvIsMessageDeleted = true;
		$this->cnvMessageSubject = null;
		$this->cnvMessageBody = null;
		$this->uID = USER_DELETED_CONVERSATION_ID;
	}

}
