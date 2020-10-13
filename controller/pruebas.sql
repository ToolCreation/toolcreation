SELECT
     `tblcurso`.`Int_IdCurso` 
    , `tblcurso`.`FK_Instructor` 
    ,`tblcurso`.`Vch_Nobre_Curso`
    , COUNT(`tblcurso`.`Vch_Nobre_Curso`) - 1 AS `CantidadDeRegistrados`
    , `tblcurso`.`Vch_Conocimiento_Curso`
    , `tblcurso`.`VchDescripcion_Curso` 
    , `tblcurso`.`VchRequisitos_Curso` 
    , `tblcategoriainstructor`.`Vch_CategoriaInst`
    , `tblnivel`.`Vch_Nombre_Nivel` 
    , `tblcurso`.`Fl_Precio_Curso` 
    , `tblmoneda`.`VchNombre_Moneda`
    , `tblcurso`.`vchImagenCurso`
    , `tblcurso`.`DT_UltimaFecha_modificacion` 
    ,CONCAT(TblUsuario.Vch_Nombre_U,' ',TblUsuario.Vch_Ap_Paterno_U ,' ',TblUsuario.Vch_Ap_Materno_U) AS 'nombreInstructor'
    ,`tblusuario`.`vchImagen` AS `imgUser`
FROM
    `tblcurso`
    INNER JOIN `tblinstructor` 
        ON (`tblcurso`.`FK_Instructor` = `tblinstructor`.`Int_IdInstructor`)
    INNER JOIN `tblmoneda` 
        ON (`tblcurso`.`Int_FkMoneda_Curso` = `tblmoneda`.`Int_Id_Moneda`)
    INNER JOIN `tblnivel` 
        ON (`tblcurso`.`Int_Fk_Nivel_Curso` = `tblnivel`.`Int_IdNivel_Curso`)
    INNER JOIN `tblusuario` 
        ON (`tblinstructor`.`Int_FkUsuario_Inst` = `tblusuario`.`Int_Id_Usuario`)
    INNER JOIN `tblventa_curso` 
        ON (`tblventa_curso`.`Int_IdCurso` = `tblcurso`.`Int_IdCurso`)
    INNER JOIN `tblcategoriainstructor` 
        ON (`tblcurso`.`Int_FkCategoria_Curso` = `tblcategoriainstructor`.`Int_IdCategoria_Inst`)
 WHERE `TblCurso.Int_Estado_Curso` = 17
GROUP BY `tblcurso`.`Int_IdCurso`,
	 `tblCurso`.`FK_Instructor`,
	`tblCurso`.`Vch_Nobre_Curso`,
	`tblCurso`.`Vch_Conocimiento_Curso` ,
	`tblCurso`.`VchDescripcion_Curso` ,
	`tblCurso`.`VchRequisitos_Curso`, 
	`tblcategoriainstructor`.`Vch_CategoriaInst`,
	`tblNivel`.`Vch_Nombre_Nivel`,
	`tblCurso`.`Fl_Precio_Curso`,
	`tblMoneda`.`VchNombre_Moneda`,
	`tblCurso`.`vchImagenCurso`,
	`tblCurso`.`DT_UltimaFecha_modificacion`,
	`tblUsuario`.`vchImagen`,
	`tblUsuario`.`Vch_Nombre_U`,
	`tblUsuario`.`Vch_Ap_Paterno_U`,
	`tblUsuario`.`Vch_Ap_Materno_U` ;