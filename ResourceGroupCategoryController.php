<?php

class ResourceGroupCategoryController extends Controller
{
	
        private $_id;
        /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'. 'listallresourcegroupcategories','ListAllDomainsInThisPlatform','addnewpartnerdomain'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ListAllDomainsForTreatyInitiation','ListAllDomains',
                                    'addNewDomainToPartnerRequest','addNewDomainToPartnerRequest','ListAllDomainPendingRequests',
                                    'retrieveDomainName','updateDomainToPartnerRequest','DeleteOnePendingRequest','ListAllDomainWouldBePartnersPendingRequests',
                                    'AcceptOrRejectWouldBeToDomainRequest','pendWouldBeToDomainRequest','ListAllDomainPartners','retrieveParnerNameInPartnership',
                                    'ModifyDomainPartnership','DeleteOnePartnership','DomainDetailInfo','totalDomainTasks','totalDomainToolboxes',
                                    'partnerdetailinfoduringinitiation','partnertoolboxesbyvisibility','ListAllThisDomainPartners','ListAllDomainsConsumingThisNetwork','ListAllDomainsInThisPlatform',
                                    'domainIsNotInPartnership','JustTesting','ListAllRegisteredDomains','ListAllDomainsForACountry','ListAllDomainPartnersInACountry',
                                    'ListAllAwaitingPartnershipRequestForDomain','ListAllPartnersForDomain','ListAllDomainsForACountry','ListAllDomainsStaffMembers','ListAllDomainPartnersInACountry',
                                    'ListAllAwaitingColleaguesRequest','ListAllDomainsMembers','ListThisDomainPartners','retrieveextrainfo','anewrequestforpartnership','rejectingrequestforpartnership',
                                    'acceptingrequestforpartnership','sendingrequestforcolleague','acceptingrequestforcolleague','rejectingrequestforcolleague',
                                    'getDomainExtraDetails','ListAllVerifieddDomains','ListTheResultsOfThisUsersVerifiedDomainsRrequest','ListAllVerifiedDomainsMembers',
                                    'ListAllConsummableVerifiedUsersByMemberDomain','ListAllConsummableVerifiedDomainsByMemberDomain','ListAllDomainsWithAwaitingVerificationRequests',
                                    'ListAllVerifiedMembersThatAreConsummablesByADomain','ListAllVerifiedDomainsThatAreConsummableByDomain','retrievedomaininfo','createNewGuestDomain'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('listallresourcegroupcategories','deleteoneresourcegroupcat'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ResourceGroupCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                $model->name = $_POST['name'];
                $model->domain_type = strtolower($_POST['domain_type']);
                $model->status = strtolower($_POST['status']);
                if(isset($_POST['subscription_type'])){
                   $model->subscription_type = strtolower($_POST['subscription_type']);
                }
                if(is_numeric($_POST['country_name'])){
                $model->country_id = $_POST['country_name'];
                
                }else{
                    $model->country_id = $_POST['country_id'];
                }
                if(isset($_POST['description'])){
                   $model->description = $_POST['description']; 
                }
                 if(isset($_POST['address'])){
                   $model->address = $_POST['address']; 
                }
                if(isset($_POST['account_number'])){
                    $model->account_number = $_POST['account_number'];
                }
                if(isset($_POST['account_type'])){
                    $model->account_type = strtolower($_POST['account_type']);
                }
                if(isset($_POST['bank_name'])){
                     $model->bank_name = $_POST['bank_name'];
                }
                if(isset($_POST['swift_code'])){
                    $model->swift_code = $_POST['swift_code'];
                }
                if(isset($_POST['sort_code'])){
                    $model->sort_code = $_POST['sort_code'];
                }
               
                if(isset($_POST['category'])){
                    $model->category = strtolower($_POST['category']);
                }
                if(isset($_POST['account_title'])){
                    $model->account_title = $_POST['account_title'];
                }
                if(isset($_POST['corporate_email'])){
                    $model->corporate_email = $_POST['corporate_email'];
                }
                if(isset($_POST['contact_email'])){
                    $model->contact_email = $_POST['contact_email'];
                }
                if(isset($_POST['contact_mobile_number'])){
                    $model->contact_mobile_number = $_POST['contact_mobile_number'];
                }
                if(isset($_POST['rc_number'])){
                     $model->rc_number = $_POST['rc_number'];
                }
                if(isset($_POST['office_number'])){
                    $model->office_number = $_POST['office_number'];
                }
                $model->create_time = new CDbExpression('NOW()');
                $model->create_user_id = Yii::app()->user->id;
                
                $icon_error_counter = 0;
                 if($_FILES['icon']['name'] != ""){
                    if($this->isIconTypeAndSizeLegal()){
                        
                       $icon_filename = $_FILES['icon']['name'];
                      $icon_size = $_FILES['icon']['size'];
                        
                    }else{
                       
                        $icon_error_counter = $icon_error_counter + 1;
                         
                    }//end of the determine size and type statement
                }else{
                    $icon_filename = $this->provideCategoryIconWhenUnavailable($model);   
                   $icon_size = 0;
             
                }//end of the if icon is empty statement
                if($icon_error_counter ==0){
                   if($model->validate()){
                           $model->icon = $this->moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename);
                           $model->icon_size = $icon_size;
                           
                       if($model->save()) {
                        
                                $msg = "'$model->name' domain was created successful";
                                 header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                 "success" => mysql_errno() == 0,
                                  "msg" => $msg)
                            );
                         
                        }else{
                            //delete all the moved files in the directory when validation error is encountered
                            $msg = 'Validaion Error: Check your file fields for correctness';
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                               );
                          }
                            }else{
                                
                                //delete all the moved files in the directory when validation error is encountered
                            $msg = "Validation Error: '$model->name' domain  was not created successful";
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                            );
                          }
                        }elseif($icon_error_counter > 0){
                        //get the platform assigned icon width and height
                            $platform_width = $this->getThePlatformSetIconWidth();
                            $platform_height = $this->getThePlatformSeticonHeight();
                            $icon_types = $this->retrieveAllTheIconMimeTypes();
                            $icon_types = json_encode($icon_types);
                            $msg = "Please check your icon file type or size as icon must be of width '$platform_width'px and height '$platform_height'px. Icon type is of types '$icon_types'";
                            header('Content-Type: application/json');
                                    echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg)
                            );
                         
                        }
                            
                
                
	}
        
        
        
        
        /**
	 This is the function that creates a new guest domain
	 */
	public function actioncreateNewGuestDomain()
	{
		$model=new ResourceGroupCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                $model->name = $_POST['name'];
                $model->domain_type = strtolower($_POST['domain_type']);
                $model->status = strtolower($_POST['status']);
                $model->is_guest_domain = 1;
                if(isset($_POST['subscription_type'])){
                   $model->subscription_type = strtolower($_POST['subscription_type']);
                }
                if(is_numeric($_POST['country_name'])){
                $model->country_id = $_POST['country_name'];
                
                }else{
                    $model->country_id = $_POST['country_id'];
                }
                if(isset($_POST['description'])){
                   $model->description = $_POST['description']; 
                }
                 if(isset($_POST['address'])){
                   $model->address = $_POST['address']; 
                }
                if(isset($_POST['account_number'])){
                    $model->account_number = $_POST['account_number'];
                }
                if(isset($_POST['account_type'])){
                    $model->account_type = strtolower($_POST['account_type']);
                }
                if(isset($_POST['bank_name'])){
                     $model->bank_name = $_POST['bank_name'];
                }
                if(isset($_POST['swift_code'])){
                    $model->swift_code = $_POST['swift_code'];
                }
                if(isset($_POST['sort_code'])){
                    $model->sort_code = $_POST['sort_code'];
                }
               
                if(isset($_POST['category'])){
                    $model->category = strtolower($_POST['category']);
                }
                if(isset($_POST['account_title'])){
                    $model->account_title = $_POST['account_title'];
                }
                if(isset($_POST['corporate_email'])){
                    $model->corporate_email = $_POST['corporate_email'];
                }
                if(isset($_POST['contact_email'])){
                    $model->contact_email = $_POST['contact_email'];
                }
                if(isset($_POST['contact_mobile_number'])){
                    $model->contact_mobile_number = $_POST['contact_mobile_number'];
                }
                if(isset($_POST['rc_number'])){
                     $model->rc_number = $_POST['rc_number'];
                }
                if(isset($_POST['office_number'])){
                    $model->office_number = $_POST['office_number'];
                }
                $model->create_time = new CDbExpression('NOW()');
                $model->create_user_id = Yii::app()->user->id;
                
                $icon_error_counter = 0;
                 if($_FILES['icon']['name'] != ""){
                    if($this->isIconTypeAndSizeLegal()){
                        
                       $icon_filename = $_FILES['icon']['name'];
                      $icon_size = $_FILES['icon']['size'];
                        
                    }else{
                       
                        $icon_error_counter = $icon_error_counter + 1;
                         
                    }//end of the determine size and type statement
                }else{
                    $icon_filename = $this->provideCategoryIconWhenUnavailable($model);   
                   $icon_size = 0;
             
                }//end of the if icon is empty statement
                if($icon_error_counter ==0){
                   if($model->validate()){
                           $model->icon = $this->moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename);
                           $model->icon_size = $icon_size;
                           
                       if($model->save()) {
                        
                                $msg = "'$model->name' domain was created successful";
                                 header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                 "success" => mysql_errno() == 0,
                                  "msg" => $msg)
                            );
                         
                        }else{
                            //delete all the moved files in the directory when validation error is encountered
                            $msg = 'Validaion Error: Check your file fields for correctness';
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                               );
                          }
                            }else{
                                
                                //delete all the moved files in the directory when validation error is encountered
                            $msg = "Validation Error: '$model->name' domain  was not created successful";
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                            );
                          }
                        }elseif($icon_error_counter > 0){
                        //get the platform assigned icon width and height
                            $platform_width = $this->getThePlatformSetIconWidth();
                            $platform_height = $this->getThePlatformSeticonHeight();
                            $icon_types = $this->retrieveAllTheIconMimeTypes();
                            $icon_types = json_encode($icon_types);
                            $msg = "Please check your icon file type or size as icon must be of width '$platform_width'px and height '$platform_height'px. Icon type is of types '$icon_types'";
                            header('Content-Type: application/json');
                                    echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg)
                            );
                         
                        }
                            
                
                
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
           // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $_id = $_POST['id'];
                $model=ResourceGroupCategory::model()->findByPk($_id);
		$model->name = $_POST['name'];
                $model->domain_type = strtolower($_POST['domain_type']);
                $model->status = strtolower($_POST['status']);
                if(isset($_POST['subscription_type'])){
                   $model->subscription_type = strtolower($_POST['subscription_type']);
                }
               if(is_numeric($_POST['country_name'])){
                $model->country_id = $_POST['country_name'];
                
                }else{
                    $model->country_id = $_POST['country_id'];
                }
                if(isset($_POST['description'])){
                   $model->description = $_POST['description']; 
                }
                 if(isset($_POST['address'])){
                   $model->address = $_POST['address']; 
                }
                if(isset($_POST['account_number'])){
                    $model->account_number = $_POST['account_number'];
                }
                if(isset($_POST['account_type'])){
                    $model->account_type = strtolower($_POST['account_type']);
                }
                if(isset($_POST['bank_name'])){
                     $model->bank_name = $_POST['bank_name'];
                }
                if(isset($_POST['swift_code'])){
                    $model->swift_code = $_POST['swift_code'];
                }
                if(isset($_POST['sort_code'])){
                    $model->sort_code = $_POST['sort_code'];
                }
                
                if(isset($_POST['category'])){
                    $model->category = strtolower($_POST['category']);
                }
                if(isset($_POST['account_title'])){
                    $model->account_title = $_POST['account_title'];
                }
                if(isset($_POST['corporate_email'])){
                    $model->corporate_email = $_POST['corporate_email'];
                }
                if(isset($_POST['contact_email'])){
                    $model->contact_email = $_POST['contact_email'];
                }
                if(isset($_POST['contact_mobile_number'])){
                    $model->contact_mobile_number = $_POST['contact_mobile_number'];
                }
                if(isset($_POST['rc_number'])){
                     $model->rc_number = $_POST['rc_number'];
                }
                if(isset($_POST['office_number'])){
                    $model->office_number = $_POST['office_number'];
                }
                $model->update_time = new CDbExpression('NOW()');
                $model->update_user_id = Yii::app()->user->id;
                
                //get the domain name
                $domain_name = $this->getThisDomainName($_id);
                
                $icon_error_counter  = 0;
                
                if($_FILES['icon']['name'] != ""){
                    if($this->isIconTypeAndSizeLegal()){
                        
                       $icon_filename = $_FILES['icon']['name'];
                       $icon_size = $_FILES['icon']['size'];
                        
                    }else{
                       
                        $icon_error_counter = $icon_error_counter + 1;
                         
                    }//end of the determine size and type statement
                }else{
                    //$model->icon = $this->retrieveThePreviousIconName($_id);
                    $icon_filename = $this->retrieveThePreviousIconName($_id);
                    $icon_size = $this->retrieveThePrreviousIconSize($_id);
             
                }//end of the if icon is empty statement
                if($icon_error_counter ==0){
                   if($model->validate()){
                           $model->icon = $this->moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename);
                           $model->icon_size = $icon_size;
                           
                       if($model->save()) {
                        
                                $msg = "'$domain_name' domain Information was successfully updated";
                                 header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                 "success" => mysql_errno() == 0,
                                  "msg" => $msg)
                            );
                         
                        }else{
                            //delete all the moved files in the directory when validation error is encountered
                            $msg = 'Validaion Error: Check your file fields for correctness';
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                               );
                          }
                            }else{
                                
                                //delete all the moved files in the directory when validation error is encountered
                            $msg = "Validation Error: '$domain_name' domain information update was not successful";
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                            );
                          }
                        }elseif($icon_error_counter > 0){
                        //get the platform assigned icon width and height
                            $platform_width = $this->getThePlatformSetIconWidth();
                            $platform_height = $this->getThePlatformSeticonHeight();
                            $icon_types = $this->retrieveAllTheIconMimeTypes();
                            $icon_types = json_encode($icon_types);
                            $msg = "Please check your icon file type or size as icon must be of width '$platform_width'px and height '$platform_height'px. Icon type is of types '$icon_types'";
                            header('Content-Type: application/json');
                                    echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg)
                            );
                         
                        }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteOneResourcegroupCat()
	{
            //delete resourcegroup category info
            $_id = $_POST['id'];
            $model=ResourceGroupCategory::model()->findByPk($_id);
            
            $domain_name = $this->getThisDomainName($_id);
            $result = $this->domainIsNotInPartnership($_id);
            
            if($result == 0){
               //delete the domain
                if($this->deleteThisDomain($_id)){
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            
                            "msg" => "'$domain_name' had successfully been deleted"
                               )
                       );
                }else{
                   header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            
                            "msg" => "'$domain_name' could not be deleted for technical reasons"
                               )
                       ); 
                }
                
                
            }else{
               header('Content-Type: application/json');
                echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                            
                            "msg" =>"'$domain_name' cannot be deleted as it is already in partnership with other domains"
                               )
                       );
            }
         
	}
        
        
        /**
         * This is the function that effects the removal of a domain
         */
        public function deleteThisDomain($domain_id){
            $cmd =Yii::app()->db->createCommand();  
            $result = $cmd->delete('resourcegroupcategory', 'id=:domainid', array(':domainid'=>$domain_id ));
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }

        /**
         * This is the function that gets a domain name
         */
        public function getThisDomainName($domain_id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain= ResourceGroupCategory::model()->find($criteria);
            
            return $domain['name'];
            
        }
        
        
        /**
         * This is the function that determines if a domain is not in any partnership or has an just have a terminated partnership
         */
        public function domainIsNotInPartnership($domain_id){
          
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('domain_has_partners')
                    ->where("domain_id=$domain_id or partner_id=$domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
            
            
            
        }
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ResourceGroupCategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 
	public function actionListAllResourcegroupCategories()
	{
           $userid = Yii::app()->user->id; 
           
           //the logged in user domain is 
           $domain_id = $this->determineAUserDomainIdGiven($userid);
           if($this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformAdmin")|| $this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformRemittanceSupport")||$this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformRemittanceAdmin")){
            $category = ResourceGroupCategory::model()->findAll();
                if($category===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode($category);
                       
                }
           }else{
               
                //spool the domain specific data corresponding to that category
                $criteria3 = new CDbCriteria();
                $criteria3->select = '*';
                $criteria3->condition='id=:id';
                $criteria3->params = array(':id'=>$domain_id);
                $category= ResourceGroupCategory::model()->findAll($criteria3);
                if($category===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode($category);
                       
                } 
                
               
           }  
	}
         * 
         */
        
        public function actionListAllResourcegroupCategories()
	{
           $userid = Yii::app()->user->id; 
           
           $category = ResourceGroupCategory::model()->findAll();
            if($category===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode($category);
                       
                }
          
               
             
	}
        
        
        /**
	 * Manages all models.
	 */
	public function actionListAllDomainsInThisPlatform()
	{
           $userid = Yii::app()->user->id; 
           
           //the logged in user domain is 
           $domain_id = $this->determineAUserDomainIdGiven($userid);
           
            $category = ResourceGroupCategory::model()->findAll();
                if($category===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode($category);
                       
                }
           
	}
        
        /**
         * This is a function that determines if a user has a particular privilege assigned to him
         */
        public function determineIfAUserHasThisPrivilegeAssigned($userid, $privilegename){
            
             $allprivileges = [];
            //spool all the privileges assigned to a user
                $criteria7 = new CDbCriteria();
                $criteria7->select = 'itemname, userid';
                $criteria7->condition='userid=:userid';
                $criteria7->params = array(':userid'=>$userid);
                $priv= AuthAssignment::model()->find($criteria7);
                
                //retrieve all the children of the role
                
                $criteria = new CDbCriteria();
                $criteria->select = 'child';
                $criteria->condition='parent=:parent';
                $criteria->params = array(':parent'=>$priv['itemname']);
                $allprivs= Authitemchild::model()->findAll($criteria);
                 
                //check to see if this privilege exist for this user
                foreach($allprivs as $pris){
                    if($this->privilegeType($pris['child'])== 0){
                        $allprivileges[] = $pris['child'];
                        
                    }elseif($this->privilegeType($pris['child'])== 1){
                        
                       $allprivileges[] = $this->retrieveAllTaskPrivileges($pris['child']); 
                    }elseif($this->privilegeType($pris['child'])== 2){
                        
                        $allprivileges[] = $this->retrieveAllRolePrivileges($pris['child']);
                    }
                    
                    
                    
                    
                }
               
                
                if(in_array($privilegename, $allprivileges)){
                    
                    return true;
                     
                }else{
                    
                    return false;
                     
                }
                
                
                
                
                
           
           
            
           
        }
        
        
        /**
         * This is the function that returns all member privileges of a task
         */
        public function retrieveAllTaskPrivileges($task){
            
            $member = [];
            
                $criteria = new CDbCriteria();
                $criteria->select = 'child';
                $criteria->condition='parent=:parent';
                $criteria->params = array(':parent'=>$task);
                $allprivs= Authitemchild::model()->findAll($criteria);
                
                foreach($allprivs as $privs){
                    if($this->privilegeType($privs['child'])== 0){
                         $member[] = $privs['child'];
                        
                    }elseif($this->privilegeType($privs['child'])== 1){
                        
                        $member[] = $this->retrieveAllTaskPrivileges($privs['child']); 
                    }
                   
                    
                }
              return $member;
               
            
        }
        
        /**
         * This is the function that returns all members in a role
         */
        public function retrieveAllRolePrivileges($role){
            
            $member = [];
            
                $criteria = new CDbCriteria();
                $criteria->select = 'child';
                $criteria->condition='parent=:parent';
                $criteria->params = array(':parent'=>$role);
                $allprivs= Authitemchild::model()->findAll($criteria);
                
                foreach($allprivs as $privs){
                    if($this->privilegeType($privs['child'])== 0){
                         $member[] = $privs['child'];
                        
                    }elseif($this->privilegeType($privs['child'])== 1){
                        
                        $member[] = $this->retrieveAllTaskPrivileges($privs['child']); 
                    }elseif($this->privilegeType($privs['child'])== 2){
                        
                        $member[] = $this->retrieveAllRolePrivileges($privs['child']); 
                    }
                   
                    
                }
              return $member;
                
            
        }
        
        
       
        
        /**
         * This is the function that determines a privilege type
         */
        public function privilegeType($privname){
            
            $criteria7 = new CDbCriteria();
                $criteria7->select = 'name, type';
                $criteria7->condition='name=:name';
                $criteria7->params = array(':name'=>$privname);
                $privs= Authitem::model()->find($criteria7);
                
                return $privs['type'];
                
                
        }
        
       
       
        
         /**
	 * Provide icon when unavailable
	 */
	public function provideCategoryIconWhenUnavailable($model)
	{
		return 'category_unavailable.png';
	}
        
        /**
         * This is the function that list all domains for partnership initiation
         */
        public function actionListAllDomains(){
            
            //get the id of the logged in user
            $userid = Yii::app()->user->id;
            
            //get the domain of the logged in user
            $domainid = $this->determineAUserDomainIdGiven($userid);
            
            //retrieve all the domains with the exception of the user's logged in domain
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id!=:id';
             $criteria->params = array(':id'=>$domainid);
             $domains= ResourceGroupCategory::model()->findAll($criteria);
                
            if($domains===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $domains
                          
                           
                           
                          
                       ));
                       
                }
            
        }

        
        /**
         * Determine a domain id of a user given his user id 
         */
        public function determineAUserDomainIdGiven_old($userid){
            
            //determine the usertype id of the user
            $typeid = $this->determineAUserUsertypeId($userid);
            //determine the usertype name of this usertypeid
            $typename = $this->determineUserTypeName($typeid);
            
            //determine the domain id given usertype name
            $domainid = $this->determineDomainIdGiveUsertypeName($typename);
            
            //determine the domain name given its id
            $name = $this->determineDomainNameGivenItId($domainid);
            //determine the domain id given its name
            $domainname = $this->determineDomainIdGivenItsName($name);
            
            return $domainname;
            
            
        }
        
        
         /**
         * Determine a domain id of a user given his user id 
         */
        public function determineAUserDomainIdGiven($userid){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = '*';
            $criteria1->condition='id=:id';
            $criteria1->params = array(':id'=>$userid);
            $user= User::model()->find($criteria1);
            
            return $user['domain_id'];
        }
        
              
        /**
         * this is the function that retrieves the grouptype id given domain name
         */
        public function determineGrouptypeIdGivenDomainName($domainname){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>$domainname);
            $grouptypeid= GroupType::model()->find($criteria);
            
            return $grouptypeid['id'];
            
            
        }
           
        /**
         * Determine a users usertype_id
         */
        public function determineAUserUsertypeId($userid){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, usertype_id';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$userid);
            $usertype= User::model()->find($criteria);
            
            return $usertype['usertype_id'];
            
            
        }
        
        /*
         * Determine a usertype name given its id
         */
        public function determineUserTypeName($usertypeid){
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='id=:id';
            $criteria1->params = array(':id'=>$usertypeid);
            $name= UserType::model()->find($criteria1);
            
            return $name['name'];
            
        }
        
        /*
         *  determine a usertype id given its name
         */
        public function determineUsertypeNameGiveId($usertypename){
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='name=:name';
            $criteria1->params = array(':name'=>$usertypename);
            $id= UserType::model()->find($criteria1);
            
            return $id['id'];
        }
        
        /*
         * Determine a domain name given a usetypername
         */
        public function determineDomainNameGiveUsertypeName($usertypename){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='name=:name';
            $criteria1->params = array(':name'=>$usertypename);
            $name= ResourcegroupCategory::model()->find($criteria1);
            
            return $name['name'];
            
        }
        
        /*
         * Determine a domain id given a usetypername
         */
        public function determineDomainIdGiveUsertypeName($usertypename){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='name=:name';
            $criteria1->params = array(':name'=>$usertypename);
            $id= ResourcegroupCategory::model()->find($criteria1);
            
            return $id['id'];
            
        }
        
        
        /**
         * Determine a domain id given its name
         */
        public function determineDomainIdGivenItsName($name){
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='name=:name';
            $criteria1->params = array(':name'=>$name);
            $id= ResourcegroupCategory::model()->find($criteria1);
            
            return $id['id'];
            
        }
        
        /**
         * Determine a domain name given its id
         */
        public function determineDomainNameGivenItId($domainid){
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='id=:id';
            $criteria1->params = array(':id'=>$domainid);
            $name= ResourcegroupCategory::model()->find($criteria1);
            
            return $name['name'];
            
            
        }
        
        /**
         * This is the function that retrieves a resource/tool id given its name
         */
        public function determineResourceOrToolId($toolname){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='name=:name';
            $criteria1->params = array(':name'=>$toolname);
            $id= Resources::model()->find($criteria1);
            
            return $id['id'];
            
        }
        
        
        /**
         * This is the function that retrieves a resource/tool name given its id
         */
        public function determineResourceOrToolName($toolid){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='id=:id';
            $criteria1->params = array(':id'=>$toolid);
            $name= Resources::model()->find($criteria1);
            
            return $name['name'];
            
        }
        
        /**
         * This is the function that retrieves a resource/tool name given its id
         */
        public function determineGrouptypeGivenDomainId($domainid){
            
            $criteria1 = new CDbCriteria();
            $criteria1->select = 'id, name';
            $criteria1->condition='id=:id';
            $criteria1->params = array(':id'=>$domainid);
            $name= GroupType::model()->find($criteria1);
            
            return $name['name'];
            
        }
        
        /**
         * This is the function the retrieves a group id given the group name
         */
        public function determineGroupIdGivenGroupName($groupname,$domainid){
            
            //obtain the grouptype id given a domain id
            $grouptype_id = $this->determineGrouptypeIdGivenDomainId($domainid);
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='name=:name and grouptype_id=:id';
            $criteria->params = array(':name'=>$groupname, ':id'=>$grouptype_id);
            $id= Group::model()->find($criteria);
            
            return $id['id'];
            
            
        }
        
        /**
         * This is the function to retrieve subgroup id given subgroup name
         */
        public function determineSubgroupIdGivenSubgroupName($subgroupname, $domainid){
            //determine the group for this subgroup            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name, group_id';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>$subgroupname);
            $groups= SubGroup::model()->findAll($criteria);
            
            foreach($groups as $group){
                $groupdomainid = $this->determineDomainIdGivenGroupId($group['group_id']);
                if($groupdomainid == $domainid){
                    $criteria1 = new CDbCriteria();
                    $criteria1->select = 'id, name';
                    $criteria1->condition='name=:name';
                    $criteria1->params = array(':name'=>$subgroupname);
                    $id= SubGroup::model()->find($criteria1);
                    
                     return $id['id'];
                    
                }
                
                
            }
            
           
            
        }
        
        /**
         * This is the function that determines grouptype is given domain id
         */
        public function determineGrouptypeIdGivenDomainId($domainid){
            
            //determine domain name
            $domainname = $this->determineDomainNameGivenItId($domainid);
            //Determine grouptype id given domain name
            $grouptypeid = $this->determineGrouptypeIdGivenDomainName($domainname);
            
            return $grouptypeid;
            
        }
        
        
        /**
         * This is the function that determines domain id given group id
         */
        public function determineDomainIdGivenGroupId($groupid){
            //determine grouptype id given group id
            $grouptypeid = $this->determineGrouptypeIdGivenGroupId($groupid);
            //determine domain id given grouptype id
            $domainid = $this->determineDomainIdGivenGrouptypeId($grouptypeid);
            
            return $domainid;
            
            
        }
        
        /**
         * This is the function that determines the grouptypeid given group id
         */
        public function determineGrouptypeIdGivenGroupId($groupid){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name, grouptype_id';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$groupid);
            $type= Group::model()->find($criteria);
            
            return $type['grouptype_id'];
            
        }
        
        /**
         * This is the function that returns domain id given grouptype id
         */
        public function determineDomainIdGivenGrouptypeId($grouptypeid){
            
            //determine the grouptype name
            $typename = $this->determineGrouptypeNameGivenGrouptypeId($grouptypeid);
            
            $domainname = $this->determineDomainNameGivenGrouptypeName($typename);
           
            //determine domain id given its id
            $domainid = $this->determineDomainIdGivenItsName($domainname);
            
            return $domainid;
            
            
        }
        
        /**
         * This is the function that determines grouptype name given its id
         **/
        public function determineGrouptypeNameGivenGrouptypeId($typeid){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$typeid);
            $type= GroupType::model()->find($criteria);
            
            return $type['name'];
            
        }
        
        /**
         * This is the function that determines domain name given grouptype name
         */
        public function determineDomainNameGivenGrouptypeName($typename){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>$typename);
            $domain= ResourcegroupCategory::model()->find($criteria);
            
            return $domain['name'];
            
        }
        
        /**
         * This is the function that obtains a toolbox name given its id 
         */
        public function determineToolboxNameGivenItsId($toolboxid){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$toolboxid);
            $toolbox= Resourcegroup::model()->find($criteria);
            
            return $toolbox['name'];
            
        }
        
        
        /**
         * This is the function that obtains a toolbox id given its name
         */
        public function determineToolboxIdGivenItsName($toolboxname){
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name';
            $criteria->condition='name=:name';
            $criteria->params = array(':name'=>$toolboxname);
            $toolbox= Resourcegroup::model()->find($criteria);
            
            return $toolbox['id'];
            
        }
        
        /**
         * This is the function that adds new domain request to a partner
         */
        public function actionAddNewDomainToPartnerRequest(){
            
            $userid = Yii::app()->user->id;
            
            //the user domain is
            $domainid = $this->determineAUserDomainIdGiven($userid);
            $partner_id = $_POST['partner'];
             //domain name 
            $domain_name = $this->determineDomainNameGivenItId($partner_id);
            $type = strtolower($_POST['type']);
            $initiator_request_status = $_POST['initiator_request_status'];
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->insert('domain_has_partners',
                                  array('domain_id'=>$domainid,
                                    'partner_id'=>$partner_id,
                                    'initiator_request_status'=>$initiator_request_status,
                                    'destination_request_status'=>"pending", 
                                    'request'=>"pending", 
                                    'type'=>$type,  
                                    'status'=>"inactive",  
                                    'create_time'=>new CDbExpression('NOW()'),
                                    'create_user_id'=>$userid
                               
		
                            )
			
                        );
            if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership request to $domain_name is successful",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership request to $domain_name was not successful"
                    ));
                    }     
            
        }
        
        /**
         * This is the function that list all pending request for partnership from a domain
         */
        public function actionListAllDomainPendingRequests(){
            
              //obtain the id of the logged in user
            $userid = Yii::app()->user->id;
            
            //determine the domain of the logged in user
            $domainid = $this->determineAUserDomainIdGiven($userid);
             if($this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformAdmin") || $this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformPartnerSupport")){
                 
                 //spool the partners of a domain
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='request=:request';
            $criteria->params = array(':request'=>"pending");
            $partners= DomainHasPartners::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "request" => $partners
                          
                           
                           
                          
                       ));
                       
                }
                 
                 
             }else{
                 
                 //spool the partners of a domain
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id and request=:request';
            $criteria->params = array(':id'=>$domainid,':request'=>"pending");
            $partners= DomainHasPartners::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "request" => $partners
                          
                           
                           
                          
                       ));
                       
                }
             }
           
        }
        
        /**
         * This is the function that retrieves a domain name give given its id
         */
        public function actionretrieveDomainName(){
            
            
            $partner_id = $_REQUEST['id'];
            $domainname = $this->determineDomainNameGivenItId($partner_id);
            
            if($domainname===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domainname" => $domainname
                          
                           
                           
                          
                       ));
                       
                }
        }
        
        /**
         * this is the function that retrieves partner name in a partnership
         */
        public function actionretrieveParnerNameInPartnership(){
            
            $domain_id = $_REQUEST['domain_id'];
            $partner_id = $_REQUEST['partner_id'];
            
            //get the logged in user id
            $userid = Yii::app()->user->id;
            //get the logged in user domain is
            $domainid = $this->determineAUserDomainIdGiven($userid);
            if($domain_id == $domainid){
                $domainname = $this->determineDomainNameGivenItId($partner_id);
            }else{
                 $domainname = $this->determineDomainNameGivenItId($domain_id);
            }
           
            
            if($domainname===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domainname" => $domainname
                          
                           
                           
                          
                       ));
                       
                } 
            
        }
        
        /**
         * This is the function that is used to update pending domain request to partners
         */
        public function actionupdateDomainToPartnerRequest(){
            
            $userid = Yii::app()->user->id;
            
            //the user domain is
            //$domainid = $this->determineAUserDomainIdGiven($userid);
            
            if(is_numeric($_POST['partner'])){
               $partner_id = $_POST['partner']; 
            }else{
                $partner_id = $_POST['partner_id']; 
            }
           $domainid = $_POST['domain_id']; 
             //domain name 
            $domain_name = $this->determineDomainNameGivenItId($partner_id);
            $type = strtolower($_POST['type']);
            $initiator_request_status = $_POST['initiator_request_status'];
            
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'initiator_request_status'=>$initiator_request_status,
                                    'destination_request_status'=>"pending", 
                                    'request'=>"pending", 
                                    'type'=>$type,  
                                    'status'=>"inactive",  
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=>$userid
                               
		
                            ),
                    ("domain_id=$domainid and partner_id=$partner_id") 
			
                        );
            if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership request to $domain_name is successful updated",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership request to $domain_name was not updated"
                    ));
                    }   
            
        }
        
        /**
         * This is the function that deletes one pending domain request to a partner
         */
        public function actionDeleteOnePendingRequest(){
            
            $domain_id = $_POST['domain_id'];
            $partner_id = $_POST['partner_id'];
            
            $domainname = $this->determineDomainNameGivenItId($domain_id);
            $partnername = $this->determineDomainNameGivenItId($partner_id);
          
            $cmd =Yii::app()->db->createCommand();  
            $result = $cmd->delete('domain_has_partners', 'domain_id=:domainid and partner_id=:partnerid', array(':domainid'=>$domain_id, ':partnerid'=>$partner_id ));
            
            if($result>0){
                
                 header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership between $domainname and $partnername is discontinued",
                       ));
            }else{
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership between $domainname and $partnername was not discontinued",
                       ));
            }
               
                
                
        }
        
        /**
         * This is the function that list all would-be partners pending request
         */
        public function actionListAllDomainWouldBePartnersPendingRequests(){
            
              //obtain the id of the logged in user
            $userid = Yii::app()->user->id;
            
            //determine the domain of the logged in user
            $domainid = $this->determineAUserDomainIdGiven($userid);
           if($this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformAdmin") || $this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformPartnerSupport")){
               
               //spool the partners of a domain
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='destination_request_status=:dest';
            $criteria->params = array(':dest'=>"pending");
            $partners= DomainHasPartners::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "request" => $partners
                          
                           
                           
                          
                       ));
                       
                }
            
               
           }else{
               
               //spool the partners of a domain
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='partner_id=:id and destination_request_status=:dest';
            $criteria->params = array(':id'=>$domainid,':dest'=>"pending");
            $partners= DomainHasPartners::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "request" => $partners
                          
                           
                           
                          
                       ));
                       
                }
            
           } 
           
        }
        
        /**
         * This is the function that accepts or rejects a would-be partners request
         */
        public function actionAcceptOrRejectWouldBeToDomainRequest(){
            
            $userid = Yii::app()->user->id;
            
            //the user domain is
            //$domainid = $this->determineAUserDomainIdGiven($userid);
            
            if(is_numeric($_POST['domain'])){
               $domain_id = $_POST['domain']; 
            }else{
                $domain_id = $_POST['domain_id']; 
            }
           $partner_id = $_POST['partner_id']; 
             //domain and partner name 
            $domain_name = $this->determineDomainNameGivenItId($domain_id);
            $partner_name = $this->determineDomainNameGivenItId($partner_id);
            
            $type = strtolower($_POST['type']);
            $destination_request_status = $_POST['destination_request_status'];
            if($destination_request_status == "accepted"){
                $request = "accepted";
                $status = "active";
            }elseif($destination_request_status == "rejected"){
                $request = "rejected";
                $status = "terminated";
            }
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'destination_request_status'=>$destination_request_status, 
                                    'request'=>$request,
                                    'type'=>$type,  
                                    'status'=>$status,
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=>$userid
                               
		
                            ),
                    ("domain_id=$domain_id and partner_id=$partner_id") 
			
                        );
            if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership request to $domain_name is successfully accepted/rejected",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership request to $domain_name was not accepted/rejected"
                    ));
                    }   
            
        }
        
        /**
         * This is the function that pend a would-be partner request
         */
        public function actionpendWouldBeToDomainRequest(){
           
            $userid = Yii::app()->user->id;
            
            //the user domain is
            //$domainid = $this->determineAUserDomainIdGiven($userid);
            
            if(is_numeric($_POST['domain'])){
               $domain_id = $_POST['domain']; 
            }else{
                $domain_id = $_POST['domain_id']; 
            }
           $partner_id = $_POST['partner_id']; 
             //domain and partner name 
            $domain_name = $this->determineDomainNameGivenItId($domain_id);
            $partner_name = $this->determineDomainNameGivenItId($partner_id);
            
            $type = strtolower($_POST['type']);
            if(isset($_POST['destination_request_status'])){
                $destination_request_status = $_POST['destination_request_status'];
            }else{
                $destination_request_status = null;
            }
            if($destination_request_status == "pending"){
                $request = "pending";
                $status = "inactive";
                
                $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'destination_request_status'=>$destination_request_status, 
                                    'request'=>$request,
                                    'type'=>$type,  
                                    'status'=>$status,
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=>$userid
                               
		
                            ),
                    ("domain_id=$domain_id and partner_id=$partner_id") 
			
                        );
            if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership request to $domain_name is pended for further review",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership request to $domain_name was not pended successfully"
                    ));
                    } 
            }else{
               //remove from the view of the active domain 
                $result = $this->deleteThisWouldBePartnership($domain_id, $partner_id);
                if($result>0){
                    if($result>0){
                
                 header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership between $domain_name and $partner_name is discontinued",
                       ));
            }else{
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership between $domain_name and $partner_name was not discontinued as required",
                       ));
            }
                    
                }
            }
               
            
        }
        
        /**
         * This is the function that deletes an unpended partnership from the database
         */
        public function deleteThisWouldBePartnership($domain_id, $partner_id){
            
             $cmd =Yii::app()->db->createCommand();  
            $result = $cmd->delete('domain_has_partners', 'domain_id=:domainid and partner_id=:partnerid', array(':domainid'=>$domain_id, ':partnerid'=>$partner_id ));
            
            return $result;
            
        }
        
        /**
         * This is the function that removes a partnership request from an active domain view
         */
        public function removePartnershipRequestFromThisDomainView($domain_id, $partner_id){
             $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'destination_request_status'=>null, 
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=>Yii::app()->user->id
                               
		
                            ),
                    ("domain_id=$domain_id and partner_id=$partner_id") 
			
                        );
             
             return $result;
            
            
        }
        
        /**
         * This is the function that list all partnerships with this domain
         */
        public function actionListAllDomainPartners(){
            
               //obtain the id of the logged in user
            $userid = Yii::app()->user->id;
            
            $domain_id = $this->determineAUserDomainIdGiven($userid);
            
            if($this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformAdmin") || $this->determineIfAUserHasThisPrivilegeAssigned($userid, "platformPartnerSupport") ){
                
                //spool all active,inactive or suspended partnerships with this domain
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            //$criteria->condition='(domain_id=:id or partner_id=:partnerid) and (request=:request and status!=:status)';
            //$criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
            $partners = DomainHasPartners::model()->findAll($criteria);
            
                       
            if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "partner" => $partners
                          
                           
                           
                          
                       ));
                       
                }
            
                
            }else{
                
                $all_domain_partnership = [];
                //get all the partnership for this domain
                $all_domain_partnerships = $this->getAllDomainPartnership($domain_id);
        
          $domain_visible_partners = [];
      
          foreach($all_domain_partnerships as $domain_partner){
             if($this->isPolicyOnOneWayPartnershipWithNonCorporateDomainsEnforceable($domain_id,$domain_partner)){
                  $domain_visible_partners[] = $domain_partner;
              }
          if($this->isPolicyOnOneWayPartnershipWithCorporateDomainsEnforceable($domain_id,$domain_partner)){
                  $domain_visible_partners[] = $domain_partner;
              }
      
              if($this->isPolicyOnTwoWayPartnershipWithNonCorporateDomainsEnforceable($domain_id,$domain_partner)){
                  $domain_visible_partners[] = $domain_partner;
              }
           
            if($this->isPolicyOnTwoWayPartnershipWithCorporateDomainsEnforceable($domain_id,$domain_partner)){
                  $domain_visible_partners[] = $domain_partner;
              }
            
       
            
          }
          //make the partner array unique
         $domain_visible_partners_unique = array_unique($domain_visible_partners);
          
          //create an array container to hold all visible partners' detail
          $partners = [];
          
          foreach($domain_visible_partners_unique as $unique_partner){
             
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='((domain_id=:id and partner_id=:partnerid) ||(domain_id=:partnerid and partner_id=:id) )';
              //  $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
                $criteria->params = array(':id'=>$domain_id,':partnerid'=>$unique_partner);
                $this_partners = DomainHasPartners::model()->find($criteria);
                
                $partners[] = $this_partners;
              
          }
            
                       
            if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "partner" => $partners,
                          
                       ));
                       
                }
            
            }
           
            
        }
        
        /**
         * This is just the testing function
         */
        public function actionJustTesting(){
            $domain_id = 1;
            $partner_id = 14;
            
            $domains = $this->isPolicyOnTwoWayPartnershipWithCorporateDomainsEnforceable($domain_id,$partner_id);
            header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            //"selected" => $selected,
                            "domains" => $domains
                            //"category" =>$category,
                           
                           
                          
                       ));
        }
        
        
        /**
         * This is the function that gets all domain partnerships
         */
        public function getAllDomainPartnership($domain_id){
            
            //create an array to hold all the domain partners
            $all_domain_partners = [];
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='(domain_id=:id or partner_id=:partnerid)';
          //  $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
            $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id);
            $partners = DomainHasPartners::model()->findAll($criteria);
            
            foreach($partners as $partner){
                if($partner['partner_id'] !== $domain_id){
                    $all_domain_partners[] = $partner['partner_id'];
                }
                if($partner['domain_id'] !== $domain_id){
                     $all_domain_partners[] = $partner['domain_id'];
                }
            }
            //get the unique domain partners ids
            
            $all_domain_partners_unique = array_unique($all_domain_partners);
            
            return $all_domain_partners_unique;
        }
        
        
        /**
         * This is the function that determines if one way partnership for non-corporate domains with this domain should be visible
         */
       public function isPolicyOnOneWayPartnershipWithNonCorporateDomainsEnforceable($domain_id,$partner_id){
            
            //confirm that the partner domain is a non corporate domain
            if($this->isThisDomainANonCorporateDomain($partner_id)){
            
            //confirm if these two domains are in one-way partnership
            if($this->isTheseTwoDomainsInOneWayPartnership($domain_id,$partner_id)){
                if($this->isTheOneWayPolicyOnNonCorporateDomainActuallyEnforceable($partner_id) && ($this->partnershipInitiator($domain_id, $partner_id) == $domain_id)){
                    return true;
              /**}else if($this->isTheOneWayPolicyOnNonCorporateDomainNotEnforceable($domain_id)){
                    return true;**/
                }else{
                    return false;
                }
            
            }else{
                return false;
            }
        
            
             }else{
                return false;
            }
       
        
       }
       
      
     /**
      * This is the function that provides the partnership initiator
      */  
       public function partnershipInitiator($domain_id, $partner_id){
           $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='(domain_id=:id && partner_id=:partnerid)';
          //  $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
            $criteria->params = array(':id'=>$domain_id,'partnerid'=>$partner_id);
            $partner = DomainHasPartners::model()->find($criteria);
            return $partner['domain_id'];
       }
        
       
       
       
       /**
        * This is the function that determines if a domain is a non-corporate domain
        */
       public function isThisDomainANonCorporateDomain($domain_id){
           
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$domain_id);
                $domain= ResourceGroupCategory::model()->find($criteria);
                
                if($domain['domain_type'] == 'individual'){
                    return true;
                }else{
                    return false;
                }
           
       }
       
       
       
       /**
        * This is the function that determines if a domain is a corporate domain
        */
       public function isThisDomainACorporateDomain($domain_id){
           
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$domain_id);
                $domain= ResourceGroupCategory::model()->find($criteria);
                
                if($domain['domain_type'] == 'corporate'){
                    return true;
                }else{
                    return false;
                }
           
       }
       
       
       /**
        * This is the function that confirms if two domains are in partnership
        */
       public function isTheseTwoDomainsInOneWayPartnership($domain_id,$partner_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='((domain_id=:id && partner_id=:partnerid) || (domain_id=:partnerid && partner_id=:id))';
          //  $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
            $criteria->params = array(':id'=>$domain_id,'partnerid'=>$partner_id);
            $partner = DomainHasPartners::model()->find($criteria);
            
            if($partner['type'] == "one_way partnership"){
                return true;
            }else{
                return false;
            }
            
            
           
       }
        
       /**
        * This is the function that determines if one way policy is actaully enforceable by a domain
        */
       public function isTheOneWayPolicyOnNonCorporateDomainActuallyEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_one_way_partnership_with_non_corporate_domains']== 1){
                return true;
            }else{
                return false;
            }
           
       }
       
       
       /**
        * This is the function that determines if one way policy is not enforceable by a domain
        */
       public function isTheOneWayPolicyOnNonCorporateDomainNotEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_one_way_partnership_with_non_corporate_domains']!= 1){
                return true;
            }else{
                return false;
            }
           
       }
       
       
        /**
        * This is the function that determines if one way policy is actaully enforceable by on corporate domain
        */
       public function isTheOneWayPolicyOnCorporateDomainsActuallyEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_one_way_partnership_with_corporate_domains']== 1){
                return true;
            }else{
                return false;
            }
           
       }
       
       
        /**
        * This is the function that determines if one way policy is actaully enforceable by on corporate domain
        */
       public function isTheOneWayPolicyOnCorporateDomainsNotEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_one_way_partnership_with_corporate_domains']== 1){
                return false;
            }else{
                return true;
            }
           
       }
       
       
       /**
        * This is the function that determines if one-way partnership with corporate domains is enforceable 
        */
      public function isPolicyOnOneWayPartnershipWithCorporateDomainsEnforceable($domain_id,$partner_id){
           
           //confirm that the partner domain is a corporate domain
            if($this->isThisDomainACorporateDomain($partner_id)){
            
            //confirm if these two domains are in one-way partnership
            if($this->isTheseTwoDomainsInOneWayPartnership($domain_id,$partner_id)){
                if($this->isTheOneWayPolicyOnCorporateDomainsActuallyEnforceable($partner_id) && ($this->partnershipInitiator($domain_id, $partner_id) == $domain_id) ){
                    return true;
             /**  }else if($this->isTheOneWayPolicyOnCorporateDomainsNotEnforceable($partner_id)){
                    return true;**/
                }else{
                    return false;
                }
            
            }else{
                return false;
            }
        
            
             }else{
                return false;
            }
       
           
           
       }
     
    
       
        
       /**
        * This is the function that determines if a two way partnership with non-corporate domain is enforceable
        */
      public function isPolicyOnTwoWayPartnershipWithNonCorporateDomainsEnforceable($domain_id,$partner_id){
           
           //confirm that the partner domain is a noncorporate domain
            if($this->isThisDomainANonCorporateDomain($partner_id)){
            
            //confirm if these two domains are in two-way partnership
            if($this->isTheseTwoDomainsInTwoWayPartnership($domain_id,$partner_id)){
                if($this->isTheTwoWayPolicyWithNonCorporateDomainsActuallyEnforceable($partner_id)){
                    return true;
                }else if($this->isTheTwoWayPolicyWithNonCorporateDomainsActuallyEnforceable($domain_id)){
                    return true;
                }else{
                    return false;
                }
            
            }else{
                return false;
            }
        
            
             }else{
                return false;
            }
           
       }
     
     
       
       
       /**
        * This is the function that determines if a two way partnership with corporate domain is enforceable
        */
       public function isPolicyOnTwoWayPartnershipWithCorporateDomainsEnforceable($domain_id,$partner_id){
           
           //confirm that the partner domain is a noncorporate domain
            if($this->isThisDomainACorporateDomain($partner_id)){
            
            //confirm if these two domains are in two-way partnership
            if($this->isTheseTwoDomainsInTwoWayPartnership($domain_id,$partner_id)){
                if($this->isTheTwoWayPolicyOnCorporateDomainsActuallyEnforceable($partner_id)){
                    return true;
              }else if($this->isTheTwoWayPolicyOnCorporateDomainsActuallyEnforceable($domain_id)){
                    return true;
                }else{
                    return false;
                }
            
            }else{
                return false;
            }
        
            
             }else{
                return false;
            }
           
       }
      
      
       
       /**
        * This is the function that determines if two domains are in two-way partnership
        */
       public function isTheseTwoDomainsInTwoWayPartnership($domain_id,$partner_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='((domain_id=:id && partner_id=:partnerid) || (domain_id=:partnerid && partner_id=:id))';
          //  $criteria->params = array(':id'=>$domain_id,'partnerid'=>$domain_id,':status'=>"terminated",':request'=>"accepted");
            $criteria->params = array(':id'=>$domain_id,'partnerid'=>$partner_id);
            $partner = DomainHasPartners::model()->find($criteria);
            
            if($partner['type'] == "two_way partnership"){
                return true;
            }else{
                return false;
            }
           
           
       }
       
       
       
       /**
        * This is the function that determines if two way policy is actaully enforceable by on non corporate domain
        */
       public function isTheTwoWayPolicyWithNonCorporateDomainsActuallyEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_two_way_partnership_with_non_corporate_domains']== 1 ){
                return true;
            }else{
                return false;
            }
           
       }
       
       
       /**
        * This is the function that determines if two way policy is actaully enforceable by a domain
        */
       public function isTheTwoWayPolicyOnCorporateDomainsActuallyEnforceable($domain_id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = DomainPolicy::model()->find($criteria);
            
            if($domain['enforce_two_way_partnership_with_corporate_domains']== 1 ){
                return true;
            }else{
                return false;
            }
           
       }
       
       
        /**
         * This is the function that modifies domain partnership
         */
        public function actionModifyDomainPartnership(){
            
            $userid = Yii::app()->user->id;
            $user_domain = $this->determineAUserDomainIdGiven($userid);
            
            $domain_id = $_POST['domain_id'];
            $partner_id = $_POST['partner_id']; 
             //domain and partner name 
            $domain_name = $this->determineDomainNameGivenItId($domain_id);
            $partner_name = $this->determineDomainNameGivenItId($partner_id);
            $status = $_POST['status']; 
            
          
            
            if($status == 'inactive'){
                  //determine if a domain is the initiator or the destination domain
                if($this->isDomainADestinationDomain($user_domain,$domain_id,$partner_id)){
                    $destination_request_status = "pending";
                    //$request = "pending";
                    $result = $this->updateTheDestinationRequestStatusOfThisPartnership($status,$destination_request_status,$domain_id,$partner_id);
                }else{
                    $initiator_request_status = "pending";
                    //$request = "pending";
                    $result = $this->updateTheInitiatorRequestStatusOfThisPartnership($status,$initiator_request_status,$domain_id,$partner_id);
                }
                
            }else{
                 //determine if a domain is the initiator or the destination domain
                if($this->isDomainADestinationDomain($user_domain,$domain_id,$partner_id)){
                    $destination_request_status = "accepted";
                    //$request = "pending";
                    $result = $this->updateTheDestinationRequestStatusOfThisPartnership($status,$destination_request_status,$domain_id,$partner_id);
                }else{
                    $initiator_request_status = "accepted";
                    //$request = "pending";
                    $result = $this->updateTheInitiatorRequestStatusOfThisPartnership($status,$initiator_request_status,$domain_id,$partner_id);
                } 
                
            }
          
            if($user_domain == $domain_id){
                if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership status with $partner_name had been modified, however, you may require the other partner to accept your modification before partnership activation",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership status with $partner_name was not modified"
                    ));
                    }  
            }else{
                if($result > 0){
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership status with $domain_name had been modified,however, you may require the other partner to accept your modification before partnership activation",
                       ));
                    
                    }else{
                    header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership status with $domain_name was not modified"
                    ));
                    }
            } 
             
            
        }
        
        /**
         * This is the function that determines if the logged in user domain is the partnership destination  or initiator domain
         */
        public function isDomainADestinationDomain($user_domain_id,$initiator_domain_id,$destination_domain_id){
            
           $partnership_initiator_domain_id = $this->getThePartnershipInitiator($initiator_domain_id,$destination_domain_id);
           if($partnership_initiator_domain_id == $user_domain_id){
               return false;
           }else{
               return true;
           }
  
        }
        
        /**
         * This is the function that determines the partnership initiator
         */
        public function getThePartnershipInitiator($initiator_domain_id,$destination_domain_id){
            
            if($this->isThereAPartnershipBetweenTheseTwoDomains($initiator_domain_id,$destination_domain_id)){
                if($this->isFirstDomainTheInitiatorDomain($initiator_domain_id,$destination_domain_id)){
                    return $initiator_domain_id;
                }else{
                    return $destination_domain_id;
                }
                
            }else{
                return 0;
            }
            
        }
        
        
        /**
         * This is the function that determines if the first domain is actually the initiator domain
         */
        public function isFirstDomainTheInitiatorDomain($initiator_domain_id,$destination_domain_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('domain_has_partners')
                    ->where("(domain_id = $initiator_domain_id && partner_id=$destination_domain_id)");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        /**
         * This is the function that determines if there is a partnership between two domains
         */
        public function isThereAPartnershipBetweenTheseTwoDomains($initiator_domain_id,$destination_domain_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('domain_has_partners')
                    ->where("(domain_id = $initiator_domain_id && partner_id=$destination_domain_id) || (domain_id = $destination_domain_id && partner_id=$initiator_domain_id)");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that updates the destination domain  information in the partnership table
         */
        public function updateTheDestinationRequestStatusOfThisPartnership($status,$destination_request_status,$domain_id,$partner_id){
            if($destination_request_status == "accepted"){
                if($this->isRequestAlsoAcceptedByTheInitiatorPartner($domain_id,$partner_id)){
                    $request = "accepted";
                    $status = "active";
                }else{
                    $request = "pending";
                    $status = "inactive";
                }
                
            }else{
                $request = "pending";
                $status = "inactive";
            }
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'status'=>$status,
                                      'request'=> $request,
                                      'destination_request_status'=>$destination_request_status,
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=> Yii::app()->user->id
                               
		
                            ),
                    ("domain_id=$domain_id and partner_id=$partner_id") 
            
            
			
                        );
            return $result;
        }
        
        
        /**
         * This is the function that determines if request is also accepted by the parnership initiator partner
         */
        public function isRequestAlsoAcceptedByTheInitiatorPartner($domain_id,$partner_id){
            //get the initiator request status
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:domainid and partner_id=:partnerid';
            $criteria->params = array(':domainid'=>$domain_id,':partnerid'=>$partner_id);
            $partner = DomainHasPartners::model()->find($criteria); 
            
            if($partner['initiator_request_status']== "accepted"){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that determines if request is also accepted by the parnership destination partner
         */
        public function isRequestAlsoAcceptedByTheDestinationPartner($domain_id,$partner_id){
            //get the initiator request status
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_id=:domainid and partner_id=:partnerid';
            $criteria->params = array(':domainid'=>$domain_id,':partnerid'=>$partner_id);
            $partner = DomainHasPartners::model()->find($criteria); 
            
            if($partner['destination_request_status']== "accepted"){
                return true;
            }else{
                return false;
            }
            
        }
        
        /**
         * This is the function that updates the initaitor information in the partnership
         */
        public function updateTheInitiatorRequestStatusOfThisPartnership($status,$initiator_request_status,$domain_id,$partner_id){
            
            if($initiator_request_status == "accepted"){
                if($this->isRequestAlsoAcceptedByTheDestinationPartner($domain_id,$partner_id)){
                    $request = "accepted";
                    $status = "active";
                }else{
                    $request = "pending";
                    $status = "inactive";
                }
                
            }else{
                $request = "pending";
                $status = "inactive";
            }
            $cmd =Yii::app()->db->createCommand();
             $result = $cmd->update('domain_has_partners',
                                  array(
                                    'status'=>$status,
                                      'request'=> $request,
                                      'initiator_request_status'=>$initiator_request_status,
                                    'update_time'=>new CDbExpression('NOW()'),
                                    'update_user_id'=>Yii::app()->user->id
                               
		
                            ),
                    ("domain_id=$domain_id and partner_id=$partner_id") 
            
            
			
                        );
             
              return $result;
            
        }
        
        /**
         * This is the function that is used to delete one partnership
         */
        public function actionDeleteOnePartnership(){
          
            $domain_id = $_POST['domain_id'];
            $partner_id = $_POST['partner_id'];
            
            $domainname = $this->determineDomainNameGivenItId($domain_id);
            $partnername = $this->determineDomainNameGivenItId($partner_id);
          
            $cmd =Yii::app()->db->createCommand();  
            $result = $cmd->delete('domain_has_partners', 'domain_id=:domainid and partner_id=:partnerid', array(':domainid'=>$domain_id, ':partnerid'=>$partner_id ));
            
            if($result>0){
                
                 header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                           "msg" =>"Partnership between $domainname and $partnername is discontinued",
                       ));
            }else{
                header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() != 0,
                           "msg" =>"Partnership between $domainname and $partnername was not discontinued",
                       ));
            }
               
            
            
        }
        
        /**
         * This is the function that retrieves detail information about a domain
         */
        public function actionDomainDetailInfo(){
            
            $domain_id = $_REQUEST['domain_id'];
            
            if(isset($_REQUEST['partner_id'])){
                $partner_id = $_REQUEST['partner_id'];
            }
            
            $userid = Yii::app()->user->id;
            
            //get the logged in user domain
            $domainid = $this->determineAUserDomainIdGiven($userid);
            
            
            if($domainid == $domain_id){
                
                //get the total user in a domain
                $domain_users = $this->totalUsersInThisDomain($partner_id);
                //get the total networks owned by this domain
                $domain_networks = $this->totalDomainNetworks($partner_id);
                //get the total toolboxes by this domain
                $domain_toolboxes = $this->totalDomainToolboxes($partner_id);
                //get the total tools by this domain
                $domain_tools = $this->totalDomainTools($partner_id);
                //get the total tasks from this domain
                $domain_tasks = $this->totalDomainTasks($partner_id);
                
                //get the domain operating country
                $country = $this->getTheDomainOperatingCompany($partner_id);
                
                //get the total number of networks this domain is connected to
                $connected_networks = $this->totalConnectedNetworksByDomain($partner_id);
                //get the total number of domains on domains own network
                $connected_to_own_networks = $this->totalNumberOfDomainsConnectedToOwnNetworks($partner_id);
                
                 //get the total number of domains partners
                $domain_partners = $this->totalNumberOfDomainPartners($partner_id);
                
                //retreive all the information about the domain
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$partner_id);
               $partners= Resourcegroupcategory::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $partners,
                            "userbase" => $domain_users,
                            "owned_toolboxes" => $domain_toolboxes,
                            "owned_tools" => $domain_tools,
                            "owned_tasks" => $domain_tasks,
                            "domain_networks" => $domain_networks,
                            "connected_networks" => $connected_networks,
                            "domains_on_own_networks" => $connected_to_own_networks,
                           "partners" => $domain_partners,
                           "country"=>$country
                          
                           
                           
                          
                       ));
                       
                } 
                
            }else{
                
              //get the total user in a domain
                $domain_users = $this->totalUsersInThisDomain($domain_id);
                //get the total networks owned by this domain
                $domain_networks = $this->totalDomainNetworks($domain_id);
                //get the total toolboxes by this domain
                $domain_toolboxes = $this->totalDomainToolboxes($domain_id);
                //get the total tools by this domain
                $domain_tools = $this->totalDomainTools($domain_id);
                //get the total tasks from this domain
                $domain_tasks = $this->totalDomainTasks($domain_id);
                 //get the domain operating country
                $country = $this->getTheDomainOperatingCompany($domain_id);
                //get the total number of networks this domain is connected to
                $connected_networks = $this->totalConnectedNetworksByDomain($domain_id);
                //get the total number of domains on domains own network
                $connected_to_own_networks = $this->totalNumberOfDomainsConnectedToOwnNetworks($domain_id);
                
                 //get the total number of domains partners
                $domain_partners = $this->totalNumberOfDomainPartners($domain_id);
                
                //retreive all the information about the domain
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$domain_id);
               $partners= Resourcegroupcategory::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $partners,
                            "userbase" => $domain_users,
                            "owned_toolboxes" => $domain_toolboxes,
                            "owned_tools" => $domain_tools,
                            "owned_tasks" => $domain_tasks,
                            "domain_networks" => $domain_networks,
                            "connected_networks" => $connected_networks,
                            "domains_on_own_networks" => $connected_to_own_networks,
                            "partners" => $domain_partners,
                           "country"=>$country
                          
                           
                           
                          
                       ));
                       
                }   
                
                
            }

            
            
        }
        
        
        /**
         * This is the function that gets a domain operating country
         */
        public function getTheDomainOperatingCompany($domain_id){
            
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$domain_id);
               $domain= Resourcegroupcategory::model()->find($criteria);
               
               return ($this->getTheCountryNameOfThisCountryId($domain['country_id']));
            
        }
        
        /*8
         * This is the function that gets the country name given the country id
         */
        public function getTheCountryNameOfThisCountryId($country_id){
            
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$country_id);
               $country= Country::model()->find($criteria);
            
               return $country['name'];
        }
        
        /**
         * This is the function that retrieves a partners details during partnership initiation
         */
        public function actionpartnerDetailInfoDuringInitiation(){
            
            $partner_id = $_REQUEST['partner_id'];
            
            $userid = Yii::app()->user->id;
            
            //get the logged in user domain
            $domainid = $this->determineAUserDomainIdGiven($userid);
            
            
                        
                //get the total user in a domain
                $domain_users = $this->totalUsersInThisDomain($partner_id);
                //get the total networks owned by this domain
                $domain_networks = $this->totalDomainNetworks($partner_id);
                //get the total toolboxes by this domain
                $domain_toolboxes = $this->totalDomainToolboxes($partner_id);
                //get the total tools by this domain
                $domain_tools = $this->totalDomainTools($partner_id);
                //get the total tasks from this domain
                $domain_tasks = $this->totalDomainTasks($partner_id);
                
                //get the total number of networks this domain is connected to
                $connected_networks = $this->totalConnectedNetworksByDomain($partner_id);
                //get the total number of domains on domains own network
                $connected_to_own_networks = $this->totalNumberOfDomainsConnectedToOwnNetworks($partner_id);
                
                 //get the total number of domains partners
                $domain_partners = $this->totalNumberOfDomainPartners($partner_id);
                
                //retreive all the information about the domain
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$partner_id);
               $partners= Resourcegroupcategory::model()->findAll($criteria);
            
                if($partners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $partners,
                            "userbase" => $domain_users,
                            "owned_toolboxes" => $domain_toolboxes,
                            "owned_tools" => $domain_tools,
                            "owned_tasks" => $domain_tasks,
                            "domain_networks" => $domain_networks,
                            "connected_networks" => $connected_networks,
                            "domains_on_own_networks" => $connected_to_own_networks,
                           "partners" => $domain_partners,
                          
                           
                           
                          
                       ));
                       
                } 
            
            
        }
        /**
         * This is the function that determines the total number of users in a domain
         */
        public function totalUsersInThisDomain($domain_id){
            
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('user')
                    ->where("domain_id = $domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
            
        }
        
        /**
         * This is the function that determines the total domain networks
         */
        public function totalDomainNetworks($domain_id){
            
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('network')
                    ->where("domain_id = $domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
            
        }
        
        /**
         * This is the function that determines the total connected networks by domain
         */
        public function totalConnectedNetworksByDomain($domain_id){
            
             $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('network_has_members')
                    ->where("member_id = $domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
        }
        
        /**
         * This is the function that determines the number of domain partners
         */
        public function totalNumberOfDomainPartners($domain_id){
            
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('domain_has_partners')
                    ->where("domain_id = $domain_id or partner_id=$domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
            
        }
        
        /**
         * This is the function that determines the total number of domains connected to own network
         */
        public function totalNumberOfDomainsConnectedToOwnNetworks($domain_id){
            
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('network_has_members')
                    ->where("member_id = $domain_id");
                $result = $cmd->queryScalar();
                
                return $result;
        }
        
        /**
         * This is the function that determines the total number of tasks own by this domain
         */
        public function totalDomainTasks($domain_id){
            
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('resources')
                    ->where("domain_id = $domain_id and parent_id is not null");
                $result = $cmd->queryScalar();
                
                return $result;
               /** if($result===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "tasks" => $result
                            
                       ));
                       
                } 
                * 
                */  
                 
                 
            
        }
        
        /**
         * This is the function that determines the total number of tools own by a domain
         */
        public function totalDomainTools($domain_id){
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('resources')
                    ->where("domain_id = $domain_id and parent_id is null");
                $result = $cmd->queryScalar();
                
                return $result;
            
        }
        
        /**
         * This is the function that determines the toal number of toolboxes consumed by a domain
         */
        public function totalDomainToolboxes($domain_id=1){
            $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('resourcegroup_has_resourcegroupcategory')
                    ->where("category_id = $domain_id");
                $result = $cmd->queryScalar();
                
               return $result;
                
               
        }
        
        /**
         * This is the function that retrieve the list of a domain partners
         */
        public function actionListAllThisDomainPartners(){
            
            //retrieve all partners connected to by this domain
            
             $domain_id = $_REQUEST['id'];
             //$domain_id = 2;
                            
            $partners = $this->retrieveThisDomainPartners($domain_id);
            $allpartners = [];
            foreach($partners as $partner){
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$partner);
               $domain_partners= ResourceGroupCategory::model()->find($criteria);
               $allpartners[] = $domain_partners;
                
            }
            
            if($allpartners===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $allpartners
                          
                           
                           
                          
                       ));
                       
                }
                 
             
            
            
        }
        
        /**
         * This is the function that retrieves all the domain partners
         */
        public function retrieveThisDomainPartners($domain_id){
            
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='domain_id=:id or partner_id=:partner';
               $criteria->params = array(':id'=>$domain_id,':partner'=>$domain_id);
               $partners= DomainHasPartners::model()->findAll($criteria);
               
               $allpartners = [];
               foreach($partners as $partner){
                   if($partner['partner_id'] == $domain_id){
                       $allpartners[] =$partner['domain_id'];
                   }else{
                       $allpartners[] =$partner['partner_id'];
                   }
                   
               }
            return $allpartners;
            
            
        }
        
        
        /**
         * This is the function that retrieves all the domain partners
         */
        public function retrieveAllPartnership(){
            
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               //$criteria->condition='domain_id=:id or partner_id=:partner';
               //$criteria->params = array(':id'=>$domain_id,':partner'=>$domain_id);
               $partners= DomainHasPartners::model()->findAll($criteria);
               
               $allpartners = [];
               foreach($partners as $partner){
                   if($partner['partner_id'] == $domain_id){
                       $allpartners[] =$partner['domain_id'];
                   }else{
                       $allpartners[] =$partner['partner_id'];
                   }
                   
               }
            return $allpartners;
            
            
        }
        
        
         /**
         * This is the function that retrieves the list of all domains that consumed a the toolbox
         */
        public function actionListAllDomainsConsumingThisToolbox(){
             //retrieve all tools in a toolbox
            
           $toolbox_id = $_REQUEST['id'];
             //$domain_id = 2;
            $domains = $this->retrieveAllDomainsConsumingThisToolbox($toolbox_id);
            $alldomains = [];
            foreach($domains as $domain){
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='id=:id';
               $criteria->params = array(':id'=>$domain);
               $consumer_domain= ResourceGroupCategory::model()->find($criteria);
               $alldomains[] = $consumer_domain;
                
            }
            
            if($alldomains===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $alldomains
                          
                           
                           
                          
                       ));
                       
                }
            
        }
        
        
        /**
         * This is the function that retrieves all the domain consuming this toolbox
         */
        public function retrieveAllDomainsConsumingThisToolbox($toolbox_id){
           
               $criteria = new CDbCriteria();
               $criteria->select = '*';
               $criteria->condition='resourcegroup_id=:id';
               $criteria->params = array(':id'=>$toolbox_id);
               $domains= ResourcegroupHasResourcegroupcategory::model()->findAll($criteria);
               
               $alldomains = [];
               foreach($domains as $domain){
                   
                   $alldomains[] = $domain['category_id'];
               }
            
               return $alldomains; 
        }
        
        
        /**
         * This is the function that determines the type and size of icon file
         */
        public function isIconTypeAndSizeLegal(){
            
           $size = []; 
            if(isset($_FILES['icon']['name'])){
                $tmpName = $_FILES['icon']['tmp_name'];
                $iconFileName = $_FILES['icon']['name'];    
                $iconFileType = $_FILES['icon']['type'];
                $iconFileSize = $_FILES['icon']['size'];
            } 
           if (isset($_FILES['icon'])) {
             $filename = $_FILES['icon']['tmp_name'];
             list($width, $height) = getimagesize($filename);
           }
      

           
            $platform_width = $this->getThePlatformSetIconWidth();
            $platform_height = $this->getThePlatformSeticonHeight();
            
            $width = $width;
            $height = $height;
           
            //$size = $width * $height;
           
            $icontypes = $this->retrieveAllTheIconMimeTypes();
            
          
           
            //if(($iconFileType === 'image/png'|| $iconFileType === 'image/jpg' || $iconFileType === 'image/jpeg') && ($iconFileSize = 256 * 256)){
            if((in_array($iconFileType,$icontypes)) && ($platform_width == $width && $platform_height = $height)){
                return true;
               
            }else{
                return false;
            }
            
        }



/**
         * This is the function that retrieves the previous icon of the task in question
         */
        public function retrieveThePreviousIconName($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';   
            $criteria->params = array(':id'=>$id);
            $icon = ResourceGroupcategory::model()->find($criteria);
            
            
            return $icon['icon'];
            
            
        }
        
        /**
         * This is the function that retrieves the previous icon size
         */
        public function retrieveThePrreviousIconSize($id){
           
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';   
            $criteria->params = array(':id'=>$id);
            $icon = ResourceGroupCategory::model()->find($criteria);
            
            
            return $icon['icon_size'];
        }
		
		
		
		 /**
         * This is the function that gets the platform height setting
         */
        public function getThePlatformSeticonHeight(){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
           // $criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $icon = PlatformSettings::model()->find($criteria); 
            
            return $icon['icon_height'];
        }
		
		
		
		 /**
         * This is the function that gets the platform icon set width
         */
        public function getThePlatformSetIconWidth(){
            
           $criteria = new CDbCriteria();
            $criteria->select = '*';
           // $criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $icon = PlatformSettings::model()->find($criteria); 
            
            return $icon['icon_width'];
        }
		
		
		
		/**
         * This is the function that retrieves all icon mime types in the platform
         */
        public function retrieveAllTheIconMimeTypes(){
            
            $icon_mimetype = [];
            $icon_types = [];
            $criteria = new CDbCriteria();
            $criteria->select = '*';
           // $criteria->condition='id=:id';
           // $criteria->params = array(':id'=>$id);
            $icon_mime = PlatformSettings::model()->find($criteria); 
            
            $icon_mimetype = explode(',',$icon_mime['icon_mime_type']);
            foreach($icon_mimetype as $icon){
                $icon_types[] =$icon; 
                
            }
            
            return $icon_types;
            
        }
		
		
		
		/**
         * This is the function that moves icons to its directory
         */
        public function moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename){
            
            if(isset($_FILES['icon']['name'])){
                        $tmpName = $_FILES['icon']['tmp_name'];
                        $iconName = $_FILES['icon']['name'];    
                        $iconType = $_FILES['icon']['type'];
                        $iconSize = $_FILES['icon']['size'];
                  
                   }
                    
                    if($iconName !== null) {
                        if($model->id === null){
                            if($icon_filename != 'category_unavailable.png'){
                                $iconFileName = time().'_'.$icon_filename;  
                            }else{
                                $iconFileName = $icon_filename;  
                            }
                          
                          
                           // upload the icon file
                        if($iconName !== null){
                            	$iconPath = Yii::app()->params['icons'].$iconFileName;
				move_uploaded_file($tmpName,  $iconPath);
                                        
                        
                                return $iconFileName;
                        }else{
                            $iconFileName = $icon_filename;
                            return $iconFileName;
                        } // validate to save file
                        }else{
                            if($this->noNewIconFileProvided($model->id,$icon_filename)){
                                $iconFileName = $icon_filename; 
                                return $iconFileName;
                            }else{
                            if($icon_filename != 'category_unavailable.png'){
                                if($this->removeTheExistingIconFile($model->id)){
                                 $iconFileName = time().'_'.$icon_filename; 
                                 //$iconFileName = time().$icon_filename;  
                                   $iconPath = Yii::app()->params['icons'].$iconFileName;
                                   move_uploaded_file($tmpName,$iconPath);
                                   return $iconFileName;
                                    
                                   // $iconFileName = time().'_'.$icon_filename;  
                                    
                             }
                            }
                                
                                
                            }
                            
                            //$iconFileName = $icon_filename; 
                                              
                            
                        }
                      
                     }else{
                         $iconFileName = $icon_filename;
                         return $iconFileName;
                     }
					
                       
                               
        }
        
		
		
		 /**
         * This is the function that removes an existing video file
         */
        public function removeTheExistingIconFile($id){
            
            
            if($this->isTheIconNotTheDefault($id)){
                 //retreve the existing zip file from the database
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= ResourceGroupCategory::model()->find($criteria);
                
                //$directoryPath =  dirname(Yii::app()->request->scriptFile);
               $directoryPath = "c:\\xampp\htdocs\appspace_assets\\icons\\";
               // $iconpath = '..\appspace_assets\icons'.$icon['icon'];
                $filepath =$directoryPath.$icon['icon'];
                //$filepath = $directoryPath.$iconpath;
                
                if(unlink($filepath)){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
           
            
            
        }
        
		
         /**
         * This is the function that determines if  a tooltype icon is the default
         */
        public function isTheIconNotTheDefault($id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= Resourcegroupcategory::model()->find($criteria);
                
                if($icon['icon'] == 'category_unavailable.png' || $icon['icon'] ===NULL){
                    return false;
                }else{
                    return true;
                }
        }
		
		
		/**
         * This is the function to ascertain if a new icon was provided or not
         */
        public function noNewIconFileProvided($id,$icon_filename){
            
                $criteria = new CDbCriteria();
                $criteria->select = 'id, icon';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $icon= ResourceGroupCategory::model()->find($criteria);
                
                if($icon['icon']==$icon_filename){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function ttat lista all domains for a country 
        
        public function actionListAllDomainsForACountry(){
            
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='country_id=:countryid and domain_type=:type';
            $criteria->params = array(':countryid'=>$country_id, ':type'=>"$domain_type");
            $criteria->order = 'name';
            $domains= ResourceGroupCategory::model()->findAll($criteria);
            
             if($domains===null) {
                    http_response_code(404);
                    $data['error'] ='No record found';
                    echo CJSON::encode($data);
                } else {
                       header('Content-Type: application/json');
                       echo CJSON::encode(array(
                            "success" => mysql_errno() == 0,
                            "domain" => $domains
                          
                           
                           
                          
                       ));
                       
                }
            
            
            
        }
         * 
         */
        
        
	/**
         * This is the function that list all registered domains on the platform
         */
        public function actionListAllRegisteredDomains(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $domains,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $domains,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $domains,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $domains,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
            
        }
        
        
        /**
         * This is the function that lists all awaiting partnership request
         */
        public function actionListAllAwaitingPartnershipRequestForDomain(){
            
            $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category== 'all'){
                    $count = 0;
                    $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $selectable_items = [];
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$awaiting_requests)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
                       
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                         $count = 0;
                         $selectable_items = [];
                         $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$awaiting_requests)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        $count = 0;
                         $selectable_items = [];
                         $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                       foreach($domains as $dom){
                            if(in_array($dom['id'],$awaiting_requests)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                         $count = 0;
                         $selectable_items = [];
                         $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$awaiting_requests)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category== 'all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$awaiting_requests)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                             if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$awaiting_requests)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$awaiting_requests)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        $awaiting_requests = $this->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$awaiting_requests)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
        }
        
        
      
        
        /**
         * This is the function that list all accepted domain partners
         */
        public function actionListAllPartnersForDomain(){
            
            $model = new Resourcegroupcategory;
            
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category =='all'){
                    $count = 0;
                    $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $selectable_items = [];
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'name';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$domain_partners)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
                       
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count,
                                    "partners"=>$domain_partners,
                                    "all_domains"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                         $count = 0;
                         $selectable_items = [];
                        $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'name,id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$domain_partners)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        $count = 0;
                         $selectable_items = [];
                        $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                       foreach($domains as $dom){
                            if(in_array($dom['id'],$domain_partners)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                         $count = 0;
                         $selectable_items = [];
                        $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'name,id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$domain_partners)){
                                $selectable_items[] = $dom;
                                $count = $count + 1;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $selectable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =="all"){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "name,id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$domain_partners)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "name,id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                             if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$domain_partners)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "name,id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$domain_partners)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "name,id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$all_domain_string_ids)){
                                if(in_array($doma['id'],$domain_partners)){
                                     $searchable_items[] = $doma;
                                     $count= $count + 1;
                                }
                               
                            }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
        }
        
        
        
          /**
         * This is the function that retrieves all pending partners of a domain
         */
        public function getAllTheAwaitingPartnershipRequestByDomain($user_domain_id){
            $model = new DomainHasPartners;
            return $model->getAllTheAwaitingPartnershipRequestByDomain($user_domain_id);
        }
        
        
        /**
         * This is the function that retreives all partners of a domain
         */
        public function getAllThePartnersOfThisDomain($user_domain_id){
            $model = new DomainHasPartners;
            return $model->getAllThePartnersOfThisDomain($user_domain_id);
        }
        
        
        /**
         * This is the function that list all domains for a country
         */
        public function actionListAllDomainsForACountry(){
            
            $country_id = $_REQUEST['country'];
            $domain_type = $_REQUEST['domain_type'];
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='domain_type=:type and country_id=:countryid';   
             $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
             $criteria->order = "name";
             $domains = Resourcegroupcategory::model()->findAll($criteria);
             
             if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $domains,
                    
                            ));
                       
                         }
             
            
        }
        
        
        /**
         * This is the function that retrieves all the members of a partner domain
         */
        public function actionListAllDomainsStaffMembers(){
            
            $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $domain = $_REQUEST['domain'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
             //get all the partners of this domain
            $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($domain == "" or $domain==0){//this is for all domains
                   if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                                            
                       $all_partner_members = [];
                                                 
                            foreach($domain_partners as $partner){
                                if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                    $criteria = new CDbCriteria();
                                    $criteria->select = '*';
                                    $criteria->condition='domain_id=:domain and type=:type';   
                                    $criteria->params = array(':domain'=>$partner,':type'=>"staff");
                                    $criteria->order = "name";
                                    $criteria->offset = $start;
                                    //$criteria->limit = $limit;     
                                    $members = User::model()->findAll($criteria);
                                
                                    foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                   
                                }
                                
                            }
                       $members = null;
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                   
                    
                            ));
                       
                         }
                      
                        
                        
                    }else{//country was provided
                       $all_partner_members = [];
                                             
                            foreach($domain_partners as $partner){
                                
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain and type=:type';   
                                  $criteria->params = array(':domain'=>$partner,':type'=>"staff");
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                            }
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//a single domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){ //country was not provided
                       $all_partner_members = [];
                                             
                        if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain and type=:type';   
                                  $criteria->params = array(':domain'=>$domain,':type'=>"staff");
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                            
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                    }else{
                        $all_partner_members = [];
                                             
                                                         
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain and type=:type';   
                                  $criteria->params = array(':domain'=>$domain,':type'=>"staff");
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                           
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
						
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($domain == "" or $domain == 0){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                  }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                         foreach($domain_partners as $partner){
                             if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain and type=:type';   
                                        $criteria->params = array(':domain'=>$partner,':type'=>"staff");
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[] = $member;
                                               $count = $count + 1;
                                                       
                                           }
                                           
                                       }
                           
                                }
                                
                             
                         }
             
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count,
                                    "string_on_partners"=>$all_domain_string_ids
                    
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                             $count = 0;
                              foreach($domain_partners as $partner){
                              
                                  if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain and type=:type';   
                                        $criteria->params = array(':domain'=>$partner,':type'=>"staff");
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                       // $criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[] = $member;
                                               $count = $count + 1;
                                           }
                                       }
                                     
                                 }
                                  
                              }
                            
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain and type=:type';   
                                        $criteria->params = array(':domain'=>$domain,':type'=>"staff");
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[]= $member;
                                               $count = $count + 1;
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain and type=:type';   
                                        $criteria->params = array(':domain'=>$domain,':type'=>"staff");
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[]= $member;
                                               $count = $count + 1;
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
        
        }
        
        
        /**
         * This is the function that list all domain partners in a country
         */
        public function actionListAllDomainPartnersInACountry(){
            
            $model = new Resourcegroupcategory; 
            $userid = Yii::app()->user->id;
             $country_id = $_REQUEST['country'];
             $domain_type = $_REQUEST['domain_type'];
             $user_domain_id = $this->determineAUserDomainIdGiven($userid);
             
             $all_domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
             
             $all_partners = [];
             
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='domain_type=:type and country_id=:countryid';   
            $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
            $criteria->order = "name";
            $domains = Resourcegroupcategory::model()->findAll($criteria);
            
            foreach($domains as $domain){
                if(in_array($domain['id'],$all_domain_partners)){
                    $all_partners[] = $domain;
                }
            }
            if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $all_partners,
                    
                            ));
                       
                         }
            
        }
        
        
      
        /**
         * This is the that list all members of registered domains
         */
        public function actionListAllDomainsMembers(){
            
            $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $domain = $_REQUEST['domain'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
             //get all the partners of this domain
            $domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($domain == "" or $domain==0){//this is for all domains
                   if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                                            
                       $all_partner_members = [];
                                                 
                            foreach($domain_partners as $partner){
                                if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                    $criteria = new CDbCriteria();
                                    $criteria->select = '*';
                                    $criteria->condition='domain_id=:domain';   
                                    $criteria->params = array(':domain'=>$partner);
                                    $criteria->order = "name";
                                    $criteria->offset = $start;
                                    //$criteria->limit = $limit;     
                                    $members = User::model()->findAll($criteria);
                                
                                    foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                   
                                }
                                
                            }
                       $members = null;
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                   
                    
                            ));
                       
                         }
                      
                        
                        
                    }else{//country was provided
                       $all_partner_members = [];
                                             
                            foreach($domain_partners as $partner){
                                
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$partner);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                            }
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//a single domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){ //country was not provided
                       $all_partner_members = [];
                                             
                        if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                            
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                    }else{
                        $all_partner_members = [];
                                             
                                                         
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                         $all_partner_members[] = $mem;
                                    }
                                  
                              }
                                
                           
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
						
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($domain == "" or $domain == 0){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                  }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                         foreach($domain_partners as $partner){
                             if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[] = $member;
                                               $count = $count + 1;
                                                       
                                           }
                                           
                                       }
                           
                                }
                                
                             
                         }
             
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count,
                                    "string_on_partners"=>$all_domain_string_ids
                    
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                             $count = 0;
                              foreach($domain_partners as $partner){
                              
                                  if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                       // $criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[] = $member;
                                               $count = $count + 1;
                                           }
                                       }
                                     
                                 }
                                  
                              }
                            
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[]= $member;
                                               $count = $count + 1;
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['domain_id'],$all_domain_string_ids)){
                                               $all_partner_members[]= $member;
                                               $count = $count + 1;
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        /**
         * This is the function that retrieves all the partners of a domain
         */
        public function actionListThisDomainPartners(){
            
            $model = new DomainHasPartners;
            
            $domain = $_REQUEST['domain'];
            
            //get all the partners of this domain
            $domain_partners = $this->getAllThePartnersOfThisDomain($domain);
            
            $all_domain_partners = [];
            
            foreach($domain_partners as $partner){
                
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$partner);
                $domains= ResourceGroupCategory::model()->findAll($criteria);
                
                foreach($domains as $domain){
                    $all_domain_partners[] = $domain;
                }
                
            }
            if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $all_domain_partners,
                                    //"results"=>$count
                    
                            ));
                       
                         }
            
        }
        
        
        /**
         * This is the function that retrieves extra information for a domain
         */
        public function actionretrieveextrainfo(){
            
            
            $country_name = $this->getTheNameOfThisCountry($_REQUEST['country']);
                       
            header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "country" => $country_name,
                                   
                    
                            ));
            
        }
        
        
         /**
         * This is the functon that retrieves a country'a name
         */
        public function getTheNameOfThisCountry($country_id){
            $model = new Country;
            return $model->getTheNameOfThisCountry($country_id);
        }
        
        
        /**
         * This is the function that makes a new request for partnership
         */
        public function actionanewrequestforpartnership(){
            $model = new DomainHasPartners;
            $userid = Yii::app()->user->id;
            
            $target_domain = $_REQUEST['id'];
            $requester_domain = $this->determineAUserDomainIdGiven($userid);
            $target_domain_name = $this->getThisDomainName($target_domain);
            
            if($model->isRequestingDomainEligibleToMakePartnershipRequestToTheTargetDomain($requester_domain, $target_domain)){
                if($model->isPartnershipRequestSuccessfullyInitiated($requester_domain,$target_domain)){
                    
                    $msg = "Your request for partnership with the '$target_domain_name' had been sent";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
                    
                }else{
                      $msg = "Your request for partnership with the '$target_domain_name' could not be sent. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
                    
                }
                
                
            }else{
                $msg = "Its possible your domain is already in partnership with '$target_domain_name' domain or you have an already pending request for partnership. Please contact customer service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
                
            }
            
            
        }
        
        
        
       

        
        /**
         * This is the function that reject a request for partnership from a domain
         */
        public function actionrejectingrequestforpartnership(){
            
            $model = new DomainHasPartners;
            $userid = Yii::app()->user->id;
            
            $target_domain = $_REQUEST['id'];
            $requester_domain = $this->determineAUserDomainIdGiven($userid);
             $target_domain_name = $this->getThisDomainName($target_domain);
            
            if($model->isTheRejectionOfThisPartnershipRequestASuccess($requester_domain,$target_domain)){
                 $msg = "You have successfully rejected the partnership request between your entity and '$target_domain_name'. No further action is required";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }else{
                 $msg = "The attempt to reject the partnership request from '$target_domain_name' was not successful. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }
        }
        
        
        /**
         * This is the function that accepts a request for partnership from a domain
         */
        public function actionacceptingrequestforpartnership(){
            
            $model = new DomainHasPartners;
            $userid = Yii::app()->user->id;
            
            $target_domain = $_REQUEST['id'];
            $requester_domain = $this->determineAUserDomainIdGiven($userid);
             $target_domain_name = $this->getThisDomainName($target_domain);
            
            if($model->isTheAcceptanceOfThisPartnershipRequestASuccess($requester_domain,$target_domain)){
                 $msg = "You have successfully accepted the partnership request between your entity and '$target_domain_name'. Good luck with the partnership";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }else{
                 $msg = "The attempt to accept the partnership request from '$target_domain_name' was not successful. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }
        }
        
        
        /**
         * This is the function that send request for a colleague
         */
        public function actionsendingrequestforcolleague(){
            
            $model = new MemberHasColleagues;
            $userid = Yii::app()->user->id;
            
            $target_colleague = $_REQUEST['id'];
           // $requester_domain = $this->determineAUserDomainIdGiven($userid);
           $target_colleague_name = $this->getTheNameOfThisMember($target_colleague);
            
            if($model->isThisMemberEligibleForAColleagueRequestToTheTargetColleague($userid, $target_colleague)){
                if($model->isColleagueRequestSuccessfullyInitiated($userid,$target_colleague)){
                    
                    $msg = "Your colleague request to '$target_domain_name' is sent";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
                    
                }else{
                      $msg = "Your colleague request to '$target_domain_name' could not be sent. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
                    
                }
                
                
            }else{
                $msg = "Its possible you are already a colleague to '$target_colleague_name' or either of you have a colleague request that is awaiting a response. Please be patient or contact customer service for assistance";
                        header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            
                }
            }
            
            
            
            /**
         * This is the function that reject a request for colleague for a member
         */
        public function actionrejectingrequestforcolleague(){
            
            $model = new MemberHasColleagues;
            $userid = Yii::app()->user->id;
            
            $target_colleague = $_REQUEST['id'];
           // $requester_domain = $this->determineAUserDomainIdGiven($userid);
             $target_colleague_name = $this->getTheNameOfThisMember($target_colleague);
            
            if($model->isTheRejectionOfThisColleagueRequestASuccess($userid,$target_colleague)){
                 $msg = "You have successfully rejected the colleague request from '$target_colleague_name'. No further action is required";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }else{
                 $msg = "The attempt to reject the colleague request from '$target_colleague_name' was not successful. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }
        }
        
        
        
           /**
         * This is the function that accepts a request for colleague for a member
         */
        public function actionacceptingrequestforcolleague(){
            
            $model = new MemberHasColleagues;
            $userid = Yii::app()->user->id;
            
            $target_colleague = $_REQUEST['id'];
           // $requester_domain = $this->determineAUserDomainIdGiven($userid);
             $target_colleague_name = $this->getTheNameOfThisMember($target_colleague);
            
            if($model->isTheAcceptanceOfThisColleagueRequestASuccess($userid,$target_colleague)){
                 $msg = "You have successfully accepted the colleague request from '$target_colleague_name'.";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }else{
                 $msg = "The attempt to accept the colleague request from '$target_colleague_name' was not successful. Please try again or Contact Customer Service for assistance";
                  header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg,
                                   
                    
                            ));
            }
        }


        
        
        /**
         * This is the function that retrieves the name of a colleague member
         */
        public function getTheNameOfThisMember($member_id){
            $model = new User;
            return $model->getTheNameOfThisMember($member_id);
            
        }
        
        /**
         * This is the function that gets domain's extra details
         */
        public function actiongetDomainExtraDetails(){
            
             $domain_id = $_REQUEST['id'];
            
            $criteria = new CDbCriteria();
            $criteria->select = 'id, name,domain_type';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$domain_id);
            $domain = Resourcegroupcategory::model()->find($criteria);
            
            $name = $domain['name'];
            $domain_type = $domain['domain_type'];
            if($domain===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "name" => $name,
                                    "domain_type"=>$domain_type
                                    
                    
                            ));
                       
                         }
        }
        
        
        
        
        /**
         * This is the function that list all verified domains on the platform
         */
        public function actionListAllVerifieddDomains(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            //get all verified domains
            $verified_domains = $this->retrieveAllVerifiedDomains();
            $target = [];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                          if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
            
        }
        
        
        /**
         * This is the fucntion that list all verified domains
         */
        public function retrieveAllVerifiedDomains(){
            
            $model = new DomainVerification;
            return $model->retrieveAllVerifiedDomains();
            
        }
        
        
         /**
         * This is the fucntion that list all verified domains for a user
         */
        public function retrieveThisUserVerifiedDomains($userid,$user_domain_id){
            
            $model = new DomainVerification;
            return $model->retrieveThisUserVerifiedDomains($userid,$user_domain_id);
            
        }
        
        
         /**
         * This is the fucntion that retrieves  all verified users on the platform
         */
        public function retrieveAllVerifiedUsersOnThePlatform(){
            
            $model = new UserVerification;
            return $model->retrieveAllVerifiedUsersOnThePlatform();
            
        }
        
        
        
        /**
         * This is the function that list all verified domains on the platform
         */
        public function actionListTheResultsOfThisUsersVerifiedDomainsRrequest(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            //get all verified domains
            $verified_domains = $this->retrieveThisUserVerifiedDomains($userid,$user_domain_id);
            $target = [];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                          if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
        }
        
        
        
        
        /**
         * This is the that list all members of verried domain members
         */
        public function actionListAllVerifiedDomainsMembers(){
            
           $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
           $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $domain = $_REQUEST['domain'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
             //get all the verified domain
            //$domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
            $domain_partners = $model->retrieveAllDomains();
            
            //retrieve all the verified users on the patform
            $verified_users = $this->retrieveAllVerifiedUsersOnThePlatform();
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($domain == "" or $domain==0){//this is for all domains
                   if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                                            
                       $all_partner_members = [];
                                                 
                            foreach($domain_partners as $partner){
                                if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                    $criteria = new CDbCriteria();
                                    $criteria->select = '*';
                                    $criteria->condition='domain_id=:domain';   
                                    $criteria->params = array(':domain'=>$partner);
                                    $criteria->order = "name";
                                    $criteria->offset = $start;
                                    //$criteria->limit = $limit;     
                                    $members = User::model()->findAll($criteria);
                                
                                    foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                   
                                }
                                
                            }
                       $members = null;
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "all_users"=>$verified_users
                                   
                    
                            ));
                       
                         }
                      
                        
                        
                    }else{//country was provided
                       $all_partner_members = [];
                                             
                            foreach($domain_partners as $partner){
                                
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$partner);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            }
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//a single domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){ //country was not provided
                       $all_partner_members = [];
                                             
                        if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                    }else{
                        $all_partner_members = [];
                                             
                                                         
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                 foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                           
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
						
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($domain == "" or $domain == 0){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                  }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                         foreach($domain_partners as $partner){
                             if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                           
                                           
                                       }
                           
                                }
                                
                             
                         }
             
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count,
                                    "string_on_partners"=>$all_domain_string_ids
                    
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                             $count = 0;
                              foreach($domain_partners as $partner){
                              
                                  if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                       // $criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                     
                                 }
                                  
                              }
                            
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                            if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        
        /**
         * This is the function that retrieves the list of all paid for consumable domains by the use's domain
         */
        public function actionListAllConsummableVerifiedDomainsByMemberDomain(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            //get all verified domains
            $verified_domains = $this->retrieveAllConsummableDomainsByThisUserDomain($user_domain_id);
            $target = [];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                          if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        /**
         * This is the function that list all consummable domains by a user's domain
         */
        public function retrieveAllConsummableDomainsByThisUserDomain($user_domain_id){
            $model = new DomainVerificationConsumedByOtherDomain;
            return $model->retrieveAllConsummableDomainsByThisUserDomain($user_domain_id);
        }
        
        
         /**
         * This is the function that list all consummable users by a user's domain
         */
        public function retrieveAllConsummableUsersByThisUserDomain($user_domain_id){
            $model = new UserVerificationConsumedByOtherDomain;
            return $model->retrieveAllConsummableUsersByThisUserDomain($user_domain_id);
        }
        
        
         /**
         * This is the that list all consumable verified users by a member domain
         */
        public function actionListAllConsummableVerifiedUsersByMemberDomain(){
            
           $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
           $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $domain = $_REQUEST['domain'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
             //get all the verified domain
            //$domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
            $domain_partners = $model->retrieveAllVerifiedDomains();
            
            //retrieve all the verified users on the patform
            $verified_users = $this->retrieveAllConsummableUsersByThisUserDomain($user_domain_id);
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($domain == "" or $domain==0){//this is for all domains
                   if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                                            
                       $all_partner_members = [];
                                                 
                            foreach($domain_partners as $partner){
                                if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                    $criteria = new CDbCriteria();
                                    $criteria->select = '*';
                                    $criteria->condition='domain_id=:domain';   
                                    $criteria->params = array(':domain'=>$partner);
                                    $criteria->order = "name";
                                    $criteria->offset = $start;
                                    //$criteria->limit = $limit;     
                                    $members = User::model()->findAll($criteria);
                                
                                    foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                   
                                }
                                
                            }
                       $members = null;
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "all_users"=>$verified_users
                                   
                    
                            ));
                       
                         }
                      
                        
                        
                    }else{//country was provided
                       $all_partner_members = [];
                                             
                            foreach($domain_partners as $partner){
                                
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$partner);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            }
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//a single domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){ //country was not provided
                       $all_partner_members = [];
                                             
                        if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                    }else{
                        $all_partner_members = [];
                                             
                                                         
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                 foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                           
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
						
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($domain == "" or $domain == 0){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                  }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                         foreach($domain_partners as $partner){
                             if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                           
                                           
                                       }
                           
                                }
                                
                             
                         }
             
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count,
                                    "string_on_partners"=>$all_domain_string_ids
                    
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                             $count = 0;
                              foreach($domain_partners as $partner){
                              
                                  if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                       // $criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                     
                                 }
                                  
                              }
                            
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                            if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        /**
         * This is the function that retrieves the list of domains with pending verification request
         */
        public function actionListAllDomainsWithAwaitingVerificationRequests(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            //get all verified domains
            $requested_domains = $this->retrieveAllDomainsWithPendingVerificationRequest();
            $target = [];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$requested_domains)){
                                $target[] =$dom;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$requested_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$requested_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$requested_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                          if(in_array($doma['id'],$requested_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$requested_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$requested_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        $criteria->offset = $start;
                        $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$requested_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        /**
         * This is the function that list all domain with pending verification request
         */
        public function retrieveAllDomainsWithPendingVerificationRequest(){
            $model = new DomainVerification;
            return $model->retrieveAllDomainsWithPendingVerificationRequest();
        }
        
        
        
        /**
         * This is the function that list all user verificatios that are consummable by a domain
         */
        public function actionListAllVerifiedMembersThatAreConsummablesByADomain(){
            
           $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
           $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $domain = $_REQUEST['domain'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
             //get all the verified domain
            //$domain_partners = $this->getAllThePartnersOfThisDomain($user_domain_id);
            $domain_partners = $model->retrieveAllDomains();
            
            //retrieve all the verified users on the patform
            $verified_users = $this->retrieveAllConsummableUsersByThisUserDomain($user_domain_id);
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($domain == "" or $domain==0){//this is for all domains
                   if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                                            
                       $all_partner_members = [];
                                                 
                            foreach($domain_partners as $partner){
                                if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                    $criteria = new CDbCriteria();
                                    $criteria->select = '*';
                                    $criteria->condition='domain_id=:domain';   
                                    $criteria->params = array(':domain'=>$partner);
                                    $criteria->order = "name";
                                    $criteria->offset = $start;
                                    //$criteria->limit = $limit;     
                                    $members = User::model()->findAll($criteria);
                                
                                    foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                   
                                }
                                
                            }
                       $members = null;
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "all_users"=>$verified_users
                                   
                    
                            ));
                       
                         }
                      
                        
                        
                    }else{//country was provided
                       $all_partner_members = [];
                                             
                            foreach($domain_partners as $partner){
                                
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$partner);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            }
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//a single domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){ //country was not provided
                       $all_partner_members = [];
                                             
                        if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                  foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                            
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
                        
                    }else{
                        $all_partner_members = [];
                                             
                                                         
                              if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                  $criteria = new CDbCriteria();
                                  $criteria->select = '*';
                                  $criteria->condition='domain_id=:domain';   
                                  $criteria->params = array(':domain'=>$domain);
                                  $criteria->order = "name";
                                  $criteria->offset = $start;
                                 // $criteria->limit = $limit;  
                                  $members = User::model()->findAll($criteria);
                                
                                 foreach($members as $mem){
                                        if(in_array($mem['id'],$verified_users)){
                                            $all_partner_members[] = $mem;
                                        }
                                         
                                    }
                                  
                              }
                                
                           
                       
                       
                       if($members===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                    
                            ));
                       
                         }
						
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($domain == "" or $domain == 0){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                  }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                         foreach($domain_partners as $partner){
                             if($model->isDomainOfTheRequiredDomainType($partner,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                           
                                           
                                       }
                           
                                }
                                
                             
                         }
             
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count,
                                    "string_on_partners"=>$all_domain_string_ids
                    
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                             $count = 0;
                              foreach($domain_partners as $partner){
                              
                                  if($model->isDomainOfTheRequiredDomainTypeAndCountry($partner,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$partner);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                       // $criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                     
                                 }
                                  
                              }
                            
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//domain was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainType($domain,$domain_type)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                            if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         $all_partner_members = [];
                          if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT domain_id FROM user where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['domain_id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                     
                           
                                
                                 if($model->isDomainOfTheRequiredDomainTypeAndCountry($domain,$domain_type,$country_id)){
                                        $criteria = new CDbCriteria();
                                        $criteria->select = '*';
                                        $criteria->condition='domain_id=:domain';   
                                        $criteria->params = array(':domain'=>$domain);
                                        $criteria->order = "name";
                                        $criteria->offset = $start;
                                        //$criteria->limit = $limit;  
                                        $members = User::model()->findAll($criteria);
                                
                                       foreach($members as $member){
                                           if(in_array($member['id'],$verified_users)){
                                               if(in_array($member['domain_id'],$all_domain_string_ids)){
                                                    $all_partner_members[] = $member;
                                                    $count = $count + 1;
                                                       
                                                }
                                           }
                                       }
                                       
                           
                                }
                                
                            
                       
                       
                       if($domain_partners===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "member" => $all_partner_members,
                                    "results"=>$count
                    
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        
        
         /**
         * This is the function that list all verified domains that is consummable by the requestor domain
         */
        public function actionListAllVerifiedDomainsThatAreConsummableByDomain(){
            
          $model = new Resourcegroupcategory;
            $userid = Yii::app()->user->id;
            
            $user_domain_id = $this->determineAUserDomainIdGiven($userid);
            $country_id = $_REQUEST['country'];
            $domain_type = strtolower($_REQUEST['domain_type']);
            $search_string = $_REQUEST['search_string'];
            $category = $_REQUEST['category'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            
            //get all verified domains
            $verified_domains = $this->retrieveAllConsummableDomainsByThisUserDomain($user_domain_id);
            $target = [];
            
            if($search_string ==""){//search string was not provided
                //if the industry was not given
                if($category == "" or $category=='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = 'id';
                        //$criteria->offset = $start;
                        //$criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainType($domain_type);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
            
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count,
                                    "verified"=>$verified_domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = 'id';
                       // $criteria->offset = $start;
                        //$criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCountry($domain_type,$country_id);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){
                        //retrieve the domain based on the industry(category), and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category");
                        $criteria->order = 'id';
                        //$criteria->offset = $start;
                       // $criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeAndCategory($domain_type,$category);
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        } else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                        
                    }else{
                        //retrieve the domain based on the industry(category), country and domain type
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (category=:category and country_id=:countryid)';
                        $criteria->params = array(':type'=>"$domain_type", ':category'=>"$category",':countryid'=>$country_id);
                        $criteria->order = 'id';
                        //$criteria->offset = $start;
                        //$criteria->limit = $limit;     
                        $domains= ResourceGroupCategory::model()->findAll($criteria);
                        
                        //get the total script count
                        $count = $model->getTheTotalCountOfThisScriptWithDomainTypeCategoryAndCountry($domain_type,$category,$country_id);
            
                        foreach($domains as $dom){
                            if(in_array($dom['id'],$verified_domains)){
                                $target[] =$dom;
                            }
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $target,
                                    "results"=>$count
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                    
                }
                
                
                
                
                
                
                
            }else{//search string wss provided
                $search_preference = strtolower($_REQUEST['search_preference']);
                
                //if the industry was not given
                if($category == "" or $category =='all'){
                    
                    if($country_id =="" or $country_id==0){//country was not provided
                        //retrieve the domains based on the domain type, search_preference and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                           foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id'];
                                   
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                       //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type';   
                        $criteria->params = array(':type'=>"$domain_type");
                        $criteria->order = "id";
                        //$criteria->offset = $start;
                       // $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                          if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{//country was provided
                        //retrieve the domains based on the country, search_preference, domain type and the search string
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and country_id=:countryid';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id);
                        $criteria->order = "id";
                       // $criteria->offset = $start;
                        //$criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                           if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                           
                           
                          
                            ));
                       
                         }
                        
                    }
                    
                    
                    
                    
                }else{//industry was provided
                    //if the country was not provided
                    if($country_id == "" or $country_id==0){//country was not provided
                       //retrieve the domain based on the industry(category), search_preference, domain type and the search strings
                        if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and category=:category';   
                        $criteria->params = array(':type'=>"$domain_type",':category'=>"$category");
                        $criteria->order = "id";
                        //$criteria->offset = $start;
                       // $criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                       foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                   "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                        
                        
                    }else{
                        //retrieve the domain based on the industry(category), search_preference, country, domain type and the search strings
                         if($search_preference == strtolower('byname')){
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                                 foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where name REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                   
                                }
                                 
                             }
                       
                            
                        }else{
                            $searchstring = explode('+',$search_string);
                            $searchWords = preg_replace('/\s/', '', $searchstring);
                            $searchable_items = [];
                            $all_domain_string_ids = [];
                            
                             foreach($searchWords as $word){
                                 $q = "SELECT id FROM resourcegroupcategory where rc_number REGEXP '$word'" ;
                                 $cmd = Yii::app()->db->createCommand($q);
                                 $results = $cmd->query();
                                 foreach($results as $res){
                                    $all_domain_string_ids[] = $res['id']; 
                                    
                                }
                                
                               
                                 
                             }
                                                       
                         
                        }
                        
                        $count = 0;
                        //retrieve all the searched domains
                        $criteria = new CDbCriteria();
                        $criteria->select = '*';
                        $criteria->condition='domain_type=:type and (country_id=:countryid and category=:category)';   
                        $criteria->params = array(':type'=>"$domain_type",':countryid'=>$country_id,':category'=>"$category");
                        $criteria->order = "id";
                        //$criteria->offset = $start;
                        //$criteria->limit = $limit;     
                        $domains = Resourcegroupcategory::model()->findAll($criteria);
                        
                        foreach($domains as $doma){
                            if(in_array($doma['id'],$verified_domains)){
                              if(in_array($doma['id'],$all_domain_string_ids)){
                                $searchable_items[] = $doma;
                                $count = $count + 1;
                                
                            }
                          }
                           
                        }
                        if($domains===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "domain" => $searchable_items,
                                    "results"=>$count,
                                    "all_string"=>$all_domain_string_ids,
                                    "domainss"=>$domains
                          
                           
                           
                          
                            ));
                       
                         }
                    }
                    
                    
                    
                }
                
                
                
            }
            
            
            
        }
        
        
        /**
         * This is the function that retrieves domains infor
         */
        public function actionretrievedomaininfo(){
            $model = new User;
            $user_id = Yii::app()->user->id;
            
            $domain_id = $model->determineAUserDomainIdGiven($user_id);
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>"$domain_id");
            $domain= ResourceGroupCategory::model()->find($criteria);
            
            if($domain===null) {
                            http_response_code(404);
                             $data['error'] ='No record found';
                             echo CJSON::encode($data);
                        }else {
                             header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                    "success" => mysql_errno() == 0,
                                    "name" => $domain['name'],
                                    "address"=>$domain['address'],
                                    "regno"=>$domain['rc_number'],
                                    "id"=>$domain['id']
                                  
                          
                            ));
                       
                         }
            
            
            
        }
        
        
        
      

	/**
	 * This is the function that adds a new domain partner
	 */
	public function actionaddnewpartnerdomain()
	{
		$model=new ResourceGroupCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                $model->name = $_POST['name'];
                $model->domain_type = strtolower($_POST['domain_type']);
                $model->status = strtolower($_POST['status']);
                if(isset($_POST['subscription_type'])){
                   $model->subscription_type = strtolower($_POST['subscription_type']);
                }
                if(is_numeric($_POST['country_name'])){
                $model->country_id = $_POST['country_name'];
                
                }else{
                    $model->country_id = $_POST['country_id'];
                }
                if(isset($_POST['description'])){
                   $model->description = $_POST['description']; 
                }
                 if(isset($_POST['address'])){
                   $model->address = $_POST['address']; 
                }
                if(isset($_POST['account_number'])){
                    $model->account_number = $_POST['account_number'];
                }
                if(isset($_POST['account_type'])){
                    $model->account_type = strtolower($_POST['account_type']);
                }
                if(isset($_POST['bank_name'])){
                     $model->bank_name = $_POST['bank_name'];
                }
                if(isset($_POST['swift_code'])){
                    $model->swift_code = $_POST['swift_code'];
                }
                if(isset($_POST['sort_code'])){
                    $model->sort_code = $_POST['sort_code'];
                }
               
                if(isset($_POST['category'])){
                    $model->category = strtolower($_POST['category']);
                }
                if(isset($_POST['account_title'])){
                    $model->account_title = $_POST['account_title'];
                }
                if(isset($_POST['corporate_email'])){
                    $model->corporate_email = $_POST['corporate_email'];
                }
                if(isset($_POST['contact_email'])){
                    $model->contact_email = $_POST['contact_email'];
                }
                if(isset($_POST['contact_mobile_number'])){
                    $model->contact_mobile_number = $_POST['contact_mobile_number'];
                }
                if(isset($_POST['rc_number'])){
                     $model->rc_number = $_POST['rc_number'];
                }
                if(isset($_POST['office_number'])){
                    $model->office_number = $_POST['office_number'];
                }
                $model->create_time = new CDbExpression('NOW()');
                $model->create_user_id = Yii::app()->user->id;
                
                $icon_error_counter = 0;
                 if($_FILES['icon']['name'] != ""){
                    if($this->isIconTypeAndSizeLegal()){
                        
                       $icon_filename = $_FILES['icon']['name'];
                      $icon_size = $_FILES['icon']['size'];
                        
                    }else{
                       
                        $icon_error_counter = $icon_error_counter + 1;
                         
                    }//end of the determine size and type statement
                }else{
                    $icon_filename = $this->provideCategoryIconWhenUnavailable($model);   
                   $icon_size = 0;
             
                }//end of the if icon is empty statement
                if($icon_error_counter ==0){
                   if($model->validate()){
                           $model->icon = $this->moveTheIconToItsPathAndReturnTheIconName($model,$icon_filename);
                           $model->icon_size = $icon_size;
                           
                       if($model->save()) {
                        
                                $msg = "'$model->name' is successfully added as a new domain partner. We will reach your contact person to provide us with the name of the person that will serve as your domain administrator on this platform";
                                 header('Content-Type: application/json');
                                echo CJSON::encode(array(
                                 "success" => mysql_errno() == 0,
                                  "msg" => $msg)
                            );
                         
                        }else{
                            //delete all the moved files in the directory when validation error is encountered
                            $msg = 'Validaion Error: Check your file fields for correctness';
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                               );
                          }
                            }else{
                                
                                //delete all the moved files in the directory when validation error is encountered
                            $msg = "Validation Error: '$model->name' domain  was not created successful";
                            header('Content-Type: application/json');
                            echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                        "msg" => $msg)
                            );
                          }
                        }elseif($icon_error_counter > 0){
                        //get the platform assigned icon width and height
                            $platform_width = $this->getThePlatformSetIconWidth();
                            $platform_height = $this->getThePlatformSeticonHeight();
                            $icon_types = $this->retrieveAllTheIconMimeTypes();
                            $icon_types = json_encode($icon_types);
                            $msg = "Please check your icon file type or size as icon must be of width '$platform_width'px and height '$platform_height'px. Icon type is of types '$icon_types'";
                            header('Content-Type: application/json');
                                    echo CJSON::encode(array(
                                    "success" => mysql_errno() != 0,
                                    "msg" => $msg)
                            );
                         
                        }
                            
                
                
	}
        
        
        
       
}
