<?php 

include 'conexion.php';
session_start();
$id = $_SESSION['id'];
$vali = '';
$i = 1;
$sql = "SELECT *
FROM registro
INNER JOIN solicitud
ON registro.id_solicitud = solicitud.id_solicitud
LEFT JOIN grupos
ON solicitud.id_grupo = grupos.id_grupo
LEFT JOIN usuarios
ON solicitud.id_usuario = usuarios.id_usuario WHERE registro.estatus_generado = 'SI' AND registro.estado_general = 'ACTIVO' AND solicitud.aprobacion_1 = '' AND tipo_solicitud = 'SA' ";
            
            if($Query = mysqli_query($link,$sql)){
                if(mysqli_num_rows($Query)>0){
                    echo'
                
                <table class="table text-center">
                        <thead>
                            <tr>
                                <th># Solicitud 1</th>
                                <th>Tipo Solicitud</th>
                                <th>Grupo</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                ';
                    while ($row = mysqli_fetch_array($Query)) {
                        if($vali != $row["id_solicitud"]){
                            echo '<tr>
                            <td>'.$row["id_solicitud"].'</td>
                            <td><input readonly type="text"  class="text-center" id="tiposolicitud" placeholder="'.$row["tipo_solicitud"].'"  value="'.$row["tipo_solicitud"].'"></td>
                            ';
                            if($row["grupo"] == 'null'){ 
                                echo  '<td> -- </td>'; 
                            }else{ 
                              echo '<td>'.$row["grupo"].'</td>';
                            }
                            echo '
                            <td><input type="checkbox" id="aprobacionsolicitud1" value="'.$row["id_solicitud"].'"></td>
                            </tr>';
                        $i++;  
                            $vali = $row["id_solicitud"];
                        }else{
                            $vali = $row["id_solicitud"];
                        } 
                    }   
                    echo ' 
                    </tbody>
                    </table>
                    <button type="submit" style="width: 100%;">COMPLETAR</button>
                   
                    ';
                }else{
                    echo '
                    <h3> NO HAY SOLICITUDES POR APORBAR</h3>
                    ';
                }               
            }else{
                echo '<h3>Error de Base de Datos</h3>';
            }
            ?>