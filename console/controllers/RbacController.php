<?php
namespace console\controllers;

use common\rbac\rules\ChangeOwnNameRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        /*// add "AddCoach" permission
        $addCoach = $auth->createPermission("AddCoach");
        $addCoach->description = "Ability to assign a coach account";
        $auth->add($addCoach);

        // add "AddEquipmentManager" permission
        $addEquipManager = $auth->createPermission("AddEquipmentManager");
        $addEquipManager->description = "Ability to assign an equipment " .
            "manager post";
        $auth->add($addEquipManager);

        // add "UpdateEquipmentRequest" permission
        $updateEquipRequest = $auth->createPermission("UpdateEquipmentRequest");
        $updateEquipRequest->description = "Ability to CRU an " .
            "equipment request";
        $auth->add($updateEquipRequest);

        // add "UpdateItem" permission
        $updateItem = $auth->createPermission("UpdateItem");
        $updateItem->description = "Ability to CRU an equipment item";
        $auth->add($updateItem);

        // add "UpdateCollection" permission
        $updateCollection = $auth->createPermission("UpdateCollection");
        $updateCollection->description = "Ability to CRU a collection";
        $auth->add($updateCollection);

        // add "CheckItemOutOrIn" permission
        $checkItem = $auth->createPermission("CheckItemOutOrIn");
        $checkItem->description = "Ability to check an item in or out";
        $auth->add($checkItem);

        // add "admin" role and give this role all permissions
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($author, $createPost);*/

        //////////////// TEST ROLES //////////////////
        /*$rule = new ChangeOwnNameRule();
        $auth->add($rule);

        $changeOwnAthleteName = $auth->createPermission("ChangeOwnAthleteName");
        $changeOwnAthleteName->description = "Ability for an athlete to change their own name";
        $changeOwnAthleteName->ruleName = $rule->name;
        $auth->add($changeOwnAthleteName);

        $changeAthleteName = $auth->createPermission("ChangeAthleteName");
        $changeAthleteName->description = "Ability to change athlete's name";
        $auth->add($changeAthleteName);

        $auth->addChild($changeOwnAthleteName, $changeAthleteName);

        $auth->assign($changeOwnAthleteName, 13); // own athlete can change his own name

        $auth->assign($changeAthleteName, 15);  // coach can change athlete names*/



        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        //$coachRole = $auth->createRole('coachRole');
        //$auth->add($coachRole);
        //////////////// END TEST ROLES //////////////////
    }

}