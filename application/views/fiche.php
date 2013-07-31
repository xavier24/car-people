<section class="content">
    <div class="row-fluid annonce">
        <div class="retour_page">
            <div class="btn clearfix">
                <span class="bouton_contour bouton_bleu">
                    <a href="javascript:history.back()" class="button bleu">Retour</a>
                </span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span8">
                <h2 class="bleu"><?php echo $annonce->d_fr_FR.' - '.$annonce->a_fr_FR ?><span><?php echo $annonce->date." ".$annonce->heure ?></span></h2>
                <p class="places orange"><?php echo $annonce->places ?> place(s) disponible(s)</p>
                <div class="row-fluid">
                    <div class="span4 depart">
                        <h4><?php echo $annonce->d_fr_FR; ?></h4>
                        <h5><?php echo $annonce->date." à ".$annonce->heure ?></h5>
                        <p>Lieu de rendez-vous&nbsp;:</p>
                        <p><?php echo $annonce->description_depart ? $annonce->description_depart : "Non précisé"?></p>
                    </div>
                    <div class="span2 direction">
                        <span class="icon-right-thin"></span>
                    </div>
                    <div class="span4 arrivee">
                        <h4><?php echo $annonce->a_fr_FR ?></h4>
                        <h5>heure estimée</h5>
                        <p>Lieu de destination&nbsp;:</p>
                        <p><?php echo $annonce->description_arrivee ? $annonce->description_arrivee : "Non précisé" ?></p>
                    </div>
                    <div class="span2">
                        <?php echo form_open('',array('method'=>'post')); ?> 
                            <div class="btn clearfix">
                                <span class="bouton_contour bouton_bleu">
                                    <button class="button bleu">Je réserve ma place au prix de 
                                        <?php if($annonce->prix <= $annonce->prix_conseil ){
                                            echo '<span class="prix_vert">'.$annonce->prix;
                                        }
                                        else{
                                            echo '<span class="prix_orange">'.$annonce->prix;
                                        }?></span>€
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="commentaire">
                        <h5>Commentaire</h5>
                        <p><?php echo $annonce->commentaire ? $annonce->commentaire : "Pas de commentaire" ?></p>
                    </div>
                    <?php if($annonce->calendar != ""){?>
                    <div class="regulier">
                        <p>Ce trajet <?php echo $annonce->regulier ? "est <span>régulier</span>" : "" ?><?php echo $annonce->regulier&&$annonce->retour ? " et " : "" ?><?php echo $annonce->retour ? "se fait en <span>allée-retour</span>" : "" ?></p>
                        <table>
                        <?php
                            $day = array("l","m","me","j","v","s","d");?>
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Lu.</td>
                                    <td>Ma.</td>
                                    <td>Me.</td>
                                    <td>Je.</td>
                                    <td>Ve.</td>
                                    <td>Sa.</td>
                                    <td>Di.</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table_allee">
                                    <td>Allée</td>
                                    <?php if(isset($annonce->calendar['0']->allee)){
                                        for($i=0;$i<count($day);$i++){
                                            if($annonce->calendar['0']->allee->$day[$i]=="0"){
                                                echo '<td>-</td>';
                                            }
                                            else{
                                                echo '<td class="heure">'.$annonce->calendar['0']->allee->$day[$i].'</td>';
                                            }
                                        }
                                    }
                                    else{                            
                                        for($i=0;$i<count($day);$i++){
                                            echo '<td>-</td>';
                                        }
                                    }?>
                                </tr>
                                <tr class="table_retour">
                                    <td>Retour</td>
                                    <?php if(isset($annonce->calendar['0']->retour)){
                                        for($i=0;$i<count($day);$i++){
                                            if($annonce->calendar['0']->retour->$day[$i]=="0"){
                                                echo '<td>-</td>'; 
                                            }
                                            else{
                                               echo '<td class="heure">'.$annonce->calendar['0']->retour->$day[$i].'</td>'; 
                                            }
                                        } 
                                    }
                                    else{
                                        for($i=0;$i<count($day);$i++){
                                            echo '<td>-</td>';
                                        }
                                    }?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="span4">
                <div class="clearfix annonce_profil">
                    <div class="clearfix">
                        <div class="clearfix">
                            <div class="photo">
                                <?php
                                if($info_membre->photo){
                                    echo '<img src="'.base_url().'web/images/membre/thumb/thumb_'.$info_membre->photo.'" />';
                                }
                                else{
                                    echo '<img src="'.base_url().'web/images/membre/thumb/thumb_default.jpg"/>';
                                }
                                ?>
                            </div>
                            <div class="info_profil">
                                <h2 class="identite <?php echo $info_membre->sexe? 'rose': 'bleu' ?>">
                                <?php echo $info_membre->username ? $info_membre->username : 'Anonyme' ; ?>
                                </h2>
                                <?php if(isset($info_membre->age)){?>
                                <div class="naissance">
                                    <span class="age">(<?php echo $info_membre->age ?>ans)</span>
                                </div>
                                <?php } 
                                    $codeLang = array('fr','nl','en','de','es','autre_lang');
                                    $afficheLang = array('Français','Neerlandais','Anglais','Allemand','Espagnol',$info_membre->autre_lang);
                                    $lang2 = 0;

                                if(!$info_membre->sexe){
                                    echo '<p class="habite">Il habite à <span class="ville_habite">'.$info_membre->ville.'</span> ('.$info_membre->province.')</p>';
                                    echo '<div class="langue_parle"><p>Il parle ';
                                    echo '<span class="langue">';
                                    for($i=0;$i<count($codeLang);$i++){
                                        if($info_membre->$codeLang[$i]){
                                            if($lang2){
                                                echo', ';
                                            }
                                            echo $afficheLang[$i];
                                            $lang2 += 1;
                                        }
                                    }
                                    echo '</span></p></div>';
                                    echo '<p>Il a <span class="orange">'.$info_membre->trajet.'</span> voyage(s) à son actif</p>';
                                }
                                else{
                                    echo '<p class="habite">Elle habite à <span class="ville_habite">'.$info_membre->ville.'</span> ('.$info_membre->province.'- '.$info_membre->pays.')</p>';
                                    echo '<div class="langue_parle"><p>Elle parle ';
                                    echo '<span class="langue">';
                                    for($i=0;$i<count($codeLang);$i++){
                                        if($info_membre->$codeLang[$i]){
                                            if($lang2){
                                                echo', ';
                                            }
                                            echo $afficheLang[$i];
                                            $lang2 += 1;
                                        }
                                    }
                                    echo '</span></p></div>';
                                    echo '<p>Elle a <span class="orange">'.$info_membre->trajet.'</span> voyage(s) à son actif</p>';
                               } ?>
                            </div>
                        </div>
                        <p class="preferences clearfix">
                            <span class="pref_fumeur<?php echo $info_membre->fumeur ?>"></span>
                            <span class="pref_musique<?php echo $info_membre->musique ?>"></span>
                            <span class="pref_bagage<?php echo $info_membre->bagage ?>"></span>
                            <span class="pref_discussion<?php echo $info_membre->discussion ?>"></span>
                            <span class="pref_animaux<?php echo $info_membre->animaux ?>"></span>
                        </p>
                        <div class="clearfix">
                            <div class="vehicule">
                                <div class="couleur_vehicule" >
                                    <div class="img_vehicule" style="background-color:<?php echo $info_membre->couleur ?>"></div>
                                </div>
                                <p class="immatriculation clearfix"><span><?php echo $info_membre->immatriculation ?></span></p>
                            </div>
                            <div class="info_vehicule">
                                <p class="marque"><?php echo $info_membre->vehicule ?></p>
                                <p class="consommation"><span class="icon-fuel"></span> <?php echo '10' ?> litres/100km</p>
                                <p class="confort">Confort&nbsp;:
                                <?php
                                for($i=1;$i<6;$i++){
                                    if( $i <= $info_membre->confort ){
                                        echo '<span class="icon-star-1"></span>';                                    
                                    }
                                    else{
                                        echo '<span class="icon-star-empty-1"></span>';
                                    }
                                }?>
                                </p>
                            </div>
                        </div>
                        <?php if( !isset($user_data)  || $annonce->user_id != $user_data->user_id){ ?>
                        <?php echo form_open('',array('method'=>'post')); ?> 
                            <div class="btn clearfix">
                                <span class="bouton_contour bouton_bleu">
                                    <button class="button bleu"><span class="icon-mail-4"></span>Contacter le covoitureur</button>
                                </span>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid carte">
        <div class="span8">
            <div id="map"></div>
        </div>
        <div class="span4">
            <div class="info_trajet">
                <h5>Infos trajet (estimations)</h5>
                <p><span class="icon-clock"</span><span id="duree"></span></p>
                <p><span class="icon-road"</span><span id="distance"></span>km</p>
            </div>
            <div class="info_etape">
                <h5>Arrêt(s) étape(s) sur le trajet</h5>
                <div>
                    <p><span class="icon-address"></span></p>
                    <p><?php echo $annonce->heure ?></p>
                    <input id="input_heure_depart" type="hidden" value="<?php echo $annonce->heure ?>" />
                    <p>Départ <?php echo $annonce->d_fr_FR.' direction '.$annonce->a_fr_FR ?></p>
                </div>
                <?php if($etapes){
                    for($i=0;$i<count($etapes);$i++){ 
                        if($etapes[$i]->stop){?>
                        <div>
                            <p><span class="icon-location"></span></p>
                            <p><?php echo $etapes[$i]->fr_FR ?><span>(+<?php echo $etapes[$i]->duree ?>min)</span></p>
                        </div>
                <?php   }
                    }                       
                }                
                ?>
                <div>
                    <p><span class="icon-flag"></span></p>
                    <p><?php echo $annonce->heure_arrivee ?></p>
                    <p>Arrivée <?php echo $annonce->a_fr_FR ?></p>
                </div>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript">
        $(function(){
            $("#map").googleMap();
            $("#map").addWay({
                start: [<?php echo $annonce->d_lat ?>,<?php echo $annonce->d_lng ?>], // Adresse postale du départ (obligatoire)
                waypoints: <?php echo $annonce->etapes ?>,
                optimizeWaypoints: true,
                end:  [<?php echo $annonce->a_lat ?>,<?php echo $annonce->a_lng ?>], // Coordonnées GPS ou adresse postale d'arrivée (obligatoire)
                route : 'way', // ID du bloc dans lequel injecter le détail de l'itinéraire (optionnel)
                langage : 'french' // Langue du détail de l'itinéraire (optionnel, en anglais)
            }) ;
        });
    </script>
</section>


    