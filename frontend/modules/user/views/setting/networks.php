<?php
/**
 * @Author: forecho
 * @Date:   2015-01-29 23:23:12
 * @Last Modified by:   forecho
 * @Last Modified time: 2015-01-30 22:56:49
 */

use frontend\widgets\Connect;
use yii\helpers\Html;

$this->title = 'Networks';
// $this->params['breadcrumbs'][] = $this->title;
?>

<?php // $this->render('_alert', ['module' => Yii::$app->getModule('user')]) ?>

<section class="container">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $auth = Connect::begin([
                    'baseAuthUrl' => ['/user/setting/connect'],
                    'accounts'    => $user->accounts,
                    'autoRender'  => false,
                    'popupMode'   => false
                ]) ?>
                <table class="table">
                    <?php foreach ($auth->getClients() as $client): ?>
                        <tr>
                            <td style="width: 32px">
                                <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
                            </td>
                            <td>
                                <?= $client->getTitle() ?>
                            </td>
                            <td style="width: 120px">
                                <?= $auth->isConnected($client) ?
                                    Html::a('Disconnect', $auth->createClientUrl($client), [
                                        'class' => 'btn btn-danger btn-block',
                                        'data-method' => 'post',
                                    ]) :
                                    Html::a('Connect', $auth->createClientUrl($client), [
                                        'class' => 'btn btn-success btn-block'
                                    ])
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php Connect::end() ?>
            </div>
        </div>
    </div>
</section>
