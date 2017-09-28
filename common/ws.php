<?php 

    include './Configuracion.php';

    $m = $_GET['m'];
    
    if ($m == "ACTUALIZAR_VOTANTES_CASILLA")
    {
        //sleep(10);
        $v      = $_GET['v'];
        
        $valor  = explode("|", $v);
        
        
        $COD_OPERACION   = $valor[0];
        $COD_CASILLA     = $valor[1];
        $CONSECUTIVO     = $valor[2];
        
        $array = array();
        
        

        $conexion = mysqli_connect($server, $user, $pass, $bd) 
        or die("Ha sucedido un error inexperado en la conexion de la base de datos");
        mysqli_set_charset($conexion, "utf8");
        
        $sql = "
                SELECT 
                    COD_ENTIDAD,
                    COD_MUNICIPIO,
                    COD_SECCION,
                    DETECTADO
                FROM 
                    operaciones_electores
                WHERE
                    COD_OPERACION   = '".$COD_OPERACION."'
                AND COD_CASILLA     = '".$COD_CASILLA."'
                AND CONSECUTIVO     = '".$CONSECUTIVO."';";
        
            $result         =  mysqli_query($conexion, $sql);
            $row            = mysqli_fetch_array($result);

            $COD_ENTIDAD    = $row['COD_ENTIDAD'];
            $COD_MUNICIPIO  = $row['COD_MUNICIPIO'];
            $COD_SECCION    = $row['COD_SECCION'];
            $DETECTADO      = $row['DETECTADO'];
            
            

        $sql = "UPDATE 
                    operaciones_electores 
                SET 
                    VOTO = 1  
                WHERE 
                    COD_OPERACION   = '".$COD_OPERACION."'
                AND COD_ENTIDAD     = '".$COD_ENTIDAD."'
                AND COD_MUNICIPIO   = '".$COD_MUNICIPIO."'
                AND COD_SECCION     = '".$COD_SECCION."'
                AND COD_CASILLA     = '".$COD_CASILLA."'
                AND CONSECUTIVO     = '".$CONSECUTIVO."';";
        mysqli_query($conexion, $sql);

        $sql = "
            UPDATE 
                operaciones_secciones
            SET
                VOTOS = 
                ( 
                    SELECT 
                        COUNT(*) AS CANTIDAD
                    FROM 
                        operaciones_electores
                    where
                        COD_OPERACION 	= '".$COD_OPERACION."'
                    and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                    and COD_MUNICIPIO 	= '".$COD_MUNICIPIO."'
                    and COD_SECCION 	= '".$COD_SECCION."'
                    AND VOTO 	= 1
                ) 
            WHERE
                COD_OPERACION 	= '".$COD_OPERACION."'
            AND COD_ENTIDAD	= '".$COD_ENTIDAD."'
            AND COD_MUNICIPIO	= '".$COD_MUNICIPIO."'
            AND COD_SECCION 	= '".$COD_SECCION."'";
            mysqli_query($conexion, $sql);
            
            
            $sql = "
            UPDATE 
                operaciones_municipios
            SET
                VOTOS = 
                ( 
                    SELECT 
                        COUNT(*) AS CANTIDAD
                    FROM 
                        operaciones_electores
                    where
                        COD_OPERACION 	= '".$COD_OPERACION."'
                    and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                    and COD_MUNICIPIO 	= '".$COD_MUNICIPIO."'
                    AND VOTO 	= 1
                ) 
            WHERE
                COD_OPERACION 	= '".$COD_OPERACION."'
            AND COD_ENTIDAD	= '".$COD_ENTIDAD."'
            AND COD_MUNICIPIO	= '".$COD_MUNICIPIO."';";
            mysqli_query($conexion, $sql);
            
            
            $sql = "
            UPDATE 
                operaciones_entidades
            SET
                VOTOS = 
                ( 
                    SELECT 
                        COUNT(*) AS CANTIDAD
                    FROM 
                        operaciones_electores
                    where
                        COD_OPERACION 	= '".$COD_OPERACION."'
                    and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                    AND VOTO 	= 1
                ) 
            WHERE
                COD_OPERACION 	= '".$COD_OPERACION."'
            AND COD_ENTIDAD	= '".$COD_ENTIDAD."';";
            mysqli_query($conexion, $sql);
            
            
        if ($DETECTADO === "1")
        {
            
            $sql = "UPDATE 
                    operaciones_electores 
                SET 
                    VOTO_DETECTADO = 1  
                WHERE 
                    COD_OPERACION   = '".$COD_OPERACION."'
                AND COD_ENTIDAD     = '".$COD_ENTIDAD."'
                AND COD_MUNICIPIO   = '".$COD_MUNICIPIO."'
                AND COD_SECCION     = '".$COD_SECCION."'
                AND COD_CASILLA     = '".$COD_CASILLA."'
                AND CONSECUTIVO     = '".$CONSECUTIVO."';";
            
            mysqli_query($conexion, $sql);

            $sql = "
                UPDATE 
                    operaciones_secciones
                SET
                    VOTOS_DETECTADOS = 
                    ( 
                        SELECT 
                            COUNT(*) AS CANTIDAD
                        FROM 
                            operaciones_electores
                        where
                            COD_OPERACION 	= '".$COD_OPERACION."'
                        and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                        and COD_MUNICIPIO 	= '".$COD_MUNICIPIO."'
                        and COD_SECCION 	= '".$COD_SECCION."'
                        AND VOTO_DETECTADO      = 1
                    ) 
                WHERE
                    COD_OPERACION 	= '".$COD_OPERACION."'
                AND COD_ENTIDAD         = '".$COD_ENTIDAD."'
                AND COD_MUNICIPIO	= '".$COD_MUNICIPIO."'
                AND COD_SECCION 	= '".$COD_SECCION."'";
                mysqli_query($conexion, $sql);


                $sql = "
                UPDATE 
                    operaciones_municipios
                SET
                    VOTOS_DETECTADOS = 
                    ( 
                        SELECT 
                            COUNT(*) AS CANTIDAD
                        FROM 
                            operaciones_electores
                        where
                            COD_OPERACION 	= '".$COD_OPERACION."'
                        and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                        and COD_MUNICIPIO 	= '".$COD_MUNICIPIO."'
                        AND VOTO_DETECTADO 	= 1
                    ) 
                WHERE
                    COD_OPERACION 	= '".$COD_OPERACION."'
                AND COD_ENTIDAD	= '".$COD_ENTIDAD."'
                AND COD_MUNICIPIO	= '".$COD_MUNICIPIO."';";
                mysqli_query($conexion, $sql);


                $sql = "
                UPDATE 
                    operaciones_entidades
                SET
                    VOTOS_DETECTADOS = 
                    ( 
                        SELECT 
                            COUNT(*) AS CANTIDAD
                        FROM 
                            operaciones_electores
                        where
                            COD_OPERACION 	= '".$COD_OPERACION."'
                        and COD_ENTIDAD 	= '".$COD_ENTIDAD."'
                        AND VOTO_DETECTADO 	= 1
                    ) 
                WHERE
                    COD_OPERACION   = '".$COD_OPERACION."'
                AND COD_ENTIDAD     = '".$COD_ENTIDAD."';";
                mysqli_query($conexion, $sql);
            
            
            
        }

        $sql = 
        "UPDATE 
            casillas 
        SET 
            VOTOS_ELECTORES = (SELECT count(*) FROM operaciones_electores WHERE COD_CASILLA = '".$valor[1]."' and VOTO = 1),
            VOTOS_AFINES = (SELECT count(*) FROM operaciones_electores WHERE COD_CASILLA = '".$valor[1]."' and VOTO = 1 and VOTO_DETECTADO = 1)
        WHERE
            NOMBRE = '".$valor[1]."';";
        
        mysqli_query($conexion, $sql);
        
        $close = mysqli_close($conexion) 
                
        or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

        if(isset($_GET["callback"]))
        {	
                echo $_GET["callback"]."(" . json_encode($array) . ");";	
        }
        else
        {
            echo  json_encode($array);
        }   
    }
    if ($m == "LOGIN_COUNT")
    {
        $v      = $_GET['v'];

        $valor  = explode("|", $v);

        $conexion = mysqli_connect($server, $user, $pass, $bd) 
        or die("Ha sucedido un error inexperado en la conexion de la base de datos");

        $sql = "SELECT * FROM operaciones_usuarios_casillas where usuario = '".$valor[0]."' AND clave_count = '".$valor[1]."'";
        mysqli_set_charset($conexion, "utf8");

        $usuarios = array(); //creamos un array

        if(!$result = mysqli_query($conexion, $sql)) die();

        $num_fila = $result->num_rows;

        if ($num_fila === 0)
        {
            $usuarios[] = array('RESULTADO'=> "0001",'MENSAJE'=> "USUARIO NO ENCONTRADO");
        }
        else 
        {
            while($row = mysqli_fetch_array($result)) 
            { 
                $usuario=$row['usuario'];
                $operacion=$row['COD_OPERACION'];
                $casilla=$row['COD_CASILLA'];
                $usuarios[] = array
                (
                    'RESULTADO'=> "0000",
                    'MENSAJE'=> "ENCUESTADOR ENCONTRADO", 
                    'usuario'=> $usuario,
                    'COD_OPERACION'=> $operacion,
                    'COD_CASILLA'=> $casilla
                );
            }
        }

        $close = mysqli_close($conexion) 
        or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

        if(isset($_GET["callback"]))
        {	
                echo $_GET["callback"]."(" . json_encode($usuarios) . ");";	
        }
        else
        {
            echo  json_encode($usuarios);
        }   
    }
?>