<?php

namespace frontend\controllers;

use intermundia\yiicms\models\Search;
use common\models\Page;
use common\models\Website;
use frontend\models\ContactForm;
use frontend\models\ContentTree;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string|Response
     */
    public function actionContactSubmit()
    {
        $websiteContentTree = Yii::$app->websiteContentTree->getModel();
        $adminEmail = $websiteContentTree->activeTranslation->admin_email ?: Yii::$app->params['adminEmail'];
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact($adminEmail)) {
//                Yii::$app->getSession()->setFlash('alert', [
//                    'body' => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
//                    'options' => ['class' => 'alert-success']
//                ]);
                return $this->render('contact_success');
            }
        }

        $page = Page::find()
            ->byId(Yii::$app->request->post('page_id'))
            ->notDeleted()
            ->one();
        return $this->render('contact', [
            'contactFormModel' => $model,
            'model' => $page
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionContactSuccess()
    {
        return $this->render('contact_success');
    }

    public function actionSitemapXml()
    {
        Yii::$app->response->format = Response::FORMAT_XML;

        $items = ContentTree::find()
            ->notHidden()
            ->notDeleted()
            ->andWhere(['<=', 'depth', 3])
            ->andWhere('table_name = :page')
            ->params([
                'page' => ContentTree::TABLE_NAME_PAGE,
            ])
            ->orderBy('lft')
            ->all();

        $sitemapItems = [];
        foreach ($items as $item) {
            $sitemapItems[] = [
                'changefreq' => 'daily',
                'url' => $item->getUrl(false, true),
                'priority' => 1 - ($item->depth - 1) / 10
            ];
        }

        return $sitemapItems;
    }

    /**
     *
     *
     * @return string
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function actionSearch()
    {
        $searchModel = new Search();
        $query = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
