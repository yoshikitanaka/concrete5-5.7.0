<?php defined('C5_EXECUTE') or die("Access Denied.");

class Concrete5_Model_AllComposerTargetType extends ComposerTargetType {

	public function configureComposerTarget(Composer $cm, $post) {
		$configuredTarget = new AllComposerTargetConfiguration();
		return $configuredTarget;
	}

}