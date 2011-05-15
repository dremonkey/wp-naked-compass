
	NakedCompass

	====================================================================

	NakedCompass is a bare-bones WordPress theme created 
	to act as a starting point for the theme designer.

	NakedCompass is free of all presentational elements and non-semantic 
	markup.

	NakedCompass is a modification of the Starkers Theme.
	The main difference is that it is built to be
	compatible with the HTML5 Boilerplate build script.
	Also I have stripped out all references to the
	twentyten theme, as well as functions that I 
	felt were unnecessary.

    My next step is to integrate the Compass Framework.

	NakedCompass is free and fully GPL-licensed, 
	so you can use it for whatever you like — even 
	your commercial projects.

	====================================================================

	TODO

	Make sure that you do the following to take full advantage of
	HTML5 Boilerplate optimization

	1. Copy the contents of the .htaccess file in the theme to the wp root directory

	====================================================================

	IMPORTANT

	The HTML5 Boilerplate build.xml file was modified
	to work correctly with this wordpress theme.

	If you update HTML5 Boilerplate, you will need to
	make the following changes to the build.xml file, as 
    well as add the patterns.txt file:

    ----------------------------------------------------
    patterns.txt 
    ----------------------------------------------------
    Used by the build file so that it does not strip out
    <!--[ ]--> comments. For some reason if you change the 
    build file so that you no longer tell it is compressing
    html files, it will strip out these comments, so we have
    to explicitly tell it to leave these comments.

	----------------------------------------------------
	build.xml line 599 
	
	Changed to make sure that we can use wp_enqueue_script 
	----------------------------------------------------

	++ OLD ++

	<replaceregexp match="&lt;!-- scripts concatenated [\d\w\s\W]*?!-- end ((scripts)|(concatenated and minified scripts))--&gt;" replace="&lt;script src='${dir.js}/scripts-${build.number}.min.js\'&gt;&lt;/script&gt;" flags="m">
            <fileset dir="./${dir.publish}" includes="${page-files}"/>
    </replaceregexp>

    ++ NEW ++

	<replaceregexp match="&lt;!-- scripts concatenated [\d\w\s\W]*?!-- end scripts--&gt;" replace="&lt;?php Utilities::add_js('/${dir.js}/scripts-${build.number}.min.js', 'jquery', true) ?&gt;" flags="m">
        <fileset dir="./${dir.publish}" includes="${page-files}"/>
    </replaceregexp>

	----------------------------------------------------
	build.xml line 606 - 668 
	
	Changed so that HTML comments are stripped out of *.php files rather than just *.html files. Modified solution based on:
	https://github.com/paulirish/html5-boilerplate/issues/392
	
	Modified by removing the --remove-quotes lines because 
	it was stripping out the quotes for element id and 
	class names
	----------------------------------------------------

	++ OLD ++

	 <target name="-htmlclean">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - maintaining whitespace"/>
        <echo message=" - removing html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg line="--type html"/>
            <arg line="--preserve-multi-spaces"/>
            <arg line="--remove-quotes"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*.html" to="../${dir.publish}/*.html"/>
            <targetfile/>
        </apply>
    </target>
    
    
    <target name="-htmlbuildkit">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - maintaining whitespace"/>
        <echo message=" - retain html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg value="--preserve-comments"/>
            <arg line="--preserve-multi-spaces"/>
            <arg line="--type html"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*.html" to="../${dir.publish}/*.html"/>
            <targetfile/>
        </apply>
    </target>
    
    
    <target name="-htmlcompress">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - removing unnecessary whitespace"/>
        <echo message=" - removing html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg line="--type html"/>
            <arg line="--remove-quotes"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*.html" to="../${dir.publish}/*.html"/>
            <targetfile/>
        </apply>
    </target>

    ++ NEW ++

      <target name="-htmlclean">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - maintaining whitespace"/>
        <echo message=" - removing html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg line="--preserve-multi-spaces"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
            <arg line="--preserve-php"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*" to="../${dir.publish}/*"/>
            <targetfile/>
        </apply>
    </target>


    <target name="-htmlbuildkit">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - maintaining whitespace"/>
        <echo message=" - retain html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg value="--preserve-comments"/>
            <arg line="--preserve-multi-spaces"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
             <arg line="--preserve-php"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*" to="../${dir.publish}/*"/>
            <targetfile/>
        </apply>
    </target>


    <target name="-htmlcompress">
        <echo message="Run htmlcompressor on the HTML"/>
        <echo message=" - removing unnecessary whitespace"/>
        <echo message=" - removing html comments"/>
        <echo message=" - compressing inline style/script tag contents"/>
        <apply executable="java" parallel="false" force="true" dest="./${dir.publish}/" >
            <fileset dir="./${dir.publish}/" includes="${page-files}"/>
            <arg value="-jar"/>
            <arg path="./${dir.build}/tools/${tool.htmlcompressor}"/>
            <arg line="--compress-js"/>
            <arg line="--compress-css"/>
            <arg line="--preserve-php"/>
            <srcfile/>
            <arg value="-o"/>
            <mapper type="glob" from="*" to="../${dir.publish}/*"/>
            <targetfile/>
        </apply>
    </target>

	====================================================================

	CHANGELOG

	Version 1.0

	Uses the 'Twenty Ten' theme and 'Starkers' as its base