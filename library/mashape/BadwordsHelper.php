<?php
class BadwordsHelper{

    public function getBadWordsArray()
    {
        $badwordsArray=array("ahole","anus","ash0le","ash0les","asholes","ass","ass monkey","assface","assh0le","assh0lez","asshole","assholes","assholz","asswipe","azzhole","bassterds","bastard","bastards","bastardz","basterds","basterdz","biatch","bitch","bitches","blow job","boffing","butthole","buttwipe","c0ck","c0cks","c0k","carpet muncher","cawk","cawks","clit","cnts","cntz","cock","cockhead","cock-head","cocks","cocksucker","cock-sucker","crap","cum","cunt","cunts","cuntz","dick","dild0","dild0s","dildo","dildos","dilld0","dilld0s","dominatricks","dominatrics","dominatrix","dyke","enema","f u c k","f u c k e r","fag","fag1t","faget","fagg1t","faggit","faggot","fagit","fags","fagz","faig","faigs","fart","flipping the bird","fuck","fucker","fuckin","fucking","fucks","fudge packer","fuk","fukah","fuken","fuker","fukin","fukk","fukkah","fukken","fukker","fukkin","g00k","gay","gayboy","gaygirl","gays","gayz","god-damned","h00r","h0ar","h0re","hells","hoar","hoor","hoore","jackoff","jap","japs","jerk-off","jisim","jiss","jizm","jizz","knob","knobs","knobz","kunt","kunts","kuntz","lesbian","lezzian","lipshits","lipshitz","masochist","masokist","massterbait","masstrbait","masstrbate","masterbaiter","masterbate","masterbates","motha fucker","motha fuker","motha fukkah","motha fukker","mother fucker","mother fukah","mother fuker","mother fukkah","mother fukker","mother-fucker","mutha fucker","mutha fukah","mutha fuker","mutha fukkah","mutha fukker","n1gr","nastt","nigger;","nigur;","niiger;","niigr;","orafis","orgasim;","orgasm","orgasum","oriface","orifice","orifiss","packi","packie","packy","paki","pakie","paky","pecker","peeenus","peeenusss","peenus","peinus","pen1s","penas","penis","penis-breath","penus","penuus","phuc","phuck","phuk","phuker","phukker","polac","polack","polak","poonani","pr1c","pr1ck","pr1k","pusse","pussee","pussy","puuke","puuker","queer","queers","queerz","qweers","qweerz","qweir","recktum","rectum","retard","sadist","scank","schlong","screwing","semen","sex","sexy","sh!t","sh1t","sh1ter","sh1ts","sh1tter","sh1tz","shit","shits","shitter","shitty","shity","shitz","shyt","shyte","shytty","shyty","skanck","skank","skankee","skankey","skanks","skanky","slut","sluts","slutty","slutz","son-of-a-bitch","tit","turd","va1jina","vag1na","vagiina","vagina","vaj1na","vajina","vullva","vulva","w0p","wh00r","wh0re","whore","xrated","xxx","b!+ch","bitch","blowjob","clit","arschloch","fuck","shit","ass","asshole","b!tch","b17ch","b1tch","bastard","bi+ch","boiolas","buceta","c0ck","cawk","chink","cipa","clits","cock","cum","cunt","dildo","dirsa","ejakulate","fatass","fcuk","fuk","fux0r","hoer","hore","jism","kawk","l3itch","l3i+ch","lesbian","masturbate","masterbat*","masterbat3","motherfucker","s.o.b.","mofo","nazi","nigga","nigger","nutsack","phuck","pimpis","pusse","pussy","scrotum","sh!t","shemale","shi+","sh!+","slut","smut","teets","tits","boobs","b00bs","teez","testical","testicle","titt","w00se","jackoff","wank","whoar","whore","*damn","*dyke","*fuck*","*shit*","@$$","amcik","andskota","arse*","assrammer","ayir","bi7ch","bitch*","bollock*","breasts","butt-pirate","cabron","cazzo","chraa","chuj","cock*","cunt*","d4mn","daygo","dego","dick*","dike*","dupa","dziwka","ejackulate","ekrem*","ekto","enculer","faen","fag*","fanculo","fanny","feces","feg","felcher","ficken","fitt*","flikker","foreskin","fotze","fu(*","fuk*","futkretzn","gay","gook","guiena","h0r","h4x0r","hell","helvete","hoer*","honkey","huevon","hui","injun","jizz","kanker*","kike","klootzak","kraut","knulle","kuk","kuksuger","kurac","kurwa","kusi*","kyrpa*","lesbo","mamhoon","masturbat*","merd*","mibun","monkleigh","mouliewop","muie","mulkku","muschi","nazis","nepesaurio","nigger*","orospu","paska*","perse","picka","pierdol*","pillu*","pimmel","piss*","pizda","poontsee","poop","porn","p0rn","pr0n","preteen","pula","pule","puta","puto","qahbeh","queef*","rautenberg","schaffer","scheiss*","schlampe","schmuck","screw","sh!t*","sharmuta","sharmute","shipal","shiz","skribz","skurwysyn","sphencter","spic","spierdalaj","splooge","suka","b00b*","testicle*","titt*","twat","vittu","wank*","wetback*","wichser","wop*","yed","zabourah","ahole","anus","ash0le","ash0les","asholes","ass","ass monkey","assface","assh0le","assh0lez","asshole","assholes","assholz","asswipe","azzhole","bassterds","bastard","bastards","bastardz","basterds","basterdz","biatch","bitch","bitches","blow job","boffing","butthole","buttwipe","c0ck","c0cks","c0k","carpet muncher","cawk","cawks","clit","cnts","cntz","cock","cockhead","cock-head","cocks","cocksucker","cock-sucker","crap","cum","cunt","cunts","cuntz","dick","dild0","dild0s","dildo","dildos","dilld0","dilld0s","dominatricks","dominatrics","dominatrix","dyke","enema","f u c k","f u c k e r","fag","fag1t","faget","fagg1t","faggit","faggot","fagit","fags","fagz","faig","faigs","fart","flipping the bird","fuck","fucker","fuckin","fucking","fucks","fudge packer","fuk","fukah","fuken","fuker","fukin","fukk","fukkah","fukken","fukker","fukkin","g00k","gay","gayboy","gaygirl","gays","gayz","god-damned","h00r","h0ar","h0re","hells","hoar","hoor","hoore","jackoff","jap","japs","jerk-off","jisim","jiss","jizm","jizz","knob","knobs","knobz","kunt","kunts","kuntz","lesbian","lezzian","lipshits","lipshitz","masochist","masokist","massterbait","masstrbait","masstrbate","masterbaiter","masterbate","masterbates","motha fucker","motha fuker","motha fukkah","motha fukker","mother fucker","mother fukah","mother fuker","mother fukkah","mother fukker","mother-fucker","mutha fucker","mutha fukah","mutha fuker","mutha fukkah","mutha fukker","n1gr","nastt","nigger;","nigur;","niiger;","niigr;","orafis","orgasim;","orgasm","orgasum","oriface","orifice","orifiss","packi","packie","packy","paki","pakie","paky","pecker","peeenus","peeenusss","peenus","peinus","pen1s","penas","penis","penis-breath","penus","penuus","phuc","phuck","phuk","phuker","phukker","polac","polack","polak","poonani","pr1c","pr1ck","pr1k","pusse","pussee","pussy","puuke","puuker","queer","queers","queerz","qweers","qweerz","qweir","recktum","rectum","retard","sadist","scank","schlong","screwing","semen","sex","sexy","sh!t","sh1t","sh1ter","sh1ts","sh1tter","sh1tz","shit","shits","shitter","shitty","shity","shitz","shyt","shyte","shytty","shyty","skanck","skank","skankee","skankey","skanks","skanky","slut","sluts","slutty","slutz","son-of-a-bitch","tit","turd","va1jina","vag1na","vagiina","vagina","vaj1na","vajina","vullva","vulva","w0p","wh00r","wh0re","whore","xrated","xxx","b!+ch","bitch","blowjob","clit","arschloch","fuck","shit","ass","asshole","b!tch","b17ch","b1tch","bastard","bi+ch","boiolas","buceta","c0ck","cawk","chink","cipa","clits","cock","cum","cunt","dildo","dirsa","ejakulate","fatass","fcuk","fuk","fux0r","hoer","hore","jism","kawk","l3itch","l3i+ch","lesbian","masturbate","masterbat*","masterbat3","motherfucker","s.o.b.","mofo","nazi","nigga","nigger","nutsack","phuck","pimpis","pusse","pussy","scrotum","sh!t","shemale","shi+","sh!+","slut","smut","teets","tits","boobs","b00bs","teez","testical","testicle","titt","w00se","jackoff","wank","whoar","whore","*damn","*dyke","*fuck*","*shit*","@$$","amcik","andskota","arse*","assrammer","ayir","bi7ch","bitch*","bollock*","breasts","butt-pirate","cabron","cazzo","chraa","chuj","cock*","cunt*","d4mn","daygo","dego","dick*","dike*","dupa","dziwka","ejackulate","ekrem*","ekto","enculer","faen","fag*","fanculo","fanny","feces","feg","felcher","ficken","fitt*","flikker","foreskin","fotze","fu(*","fuk*","futkretzn","gay","gook","guiena","h0r","h4x0r","hell","helvete","hoer*","honkey","huevon","hui","injun","jizz","kanker*","kike","klootzak","kraut","knulle","kuk","kuksuger","kurac","kurwa","kusi*","kyrpa*","lesbo","mamhoon","masturbat*","merd*","mibun","monkleigh","mouliewop","muie","mulkku","muschi","nazis","nepesaurio","nigger*","orospu","paska*","perse","picka","pierdol*","pillu*","pimmel","piss*","pizda","poontsee","poop","porn","p0rn","pr0n","preteen","pula","pule","puta","puto","qahbeh","queef*","rautenberg","schaffer","scheiss*","schlampe","schmuck","screw","sh!t*","sharmuta","sharmute","shipal","shiz","skribz","skurwysyn","sphencter","spic","spierdalaj","splooge","suka","b00b*","testicle*","titt*","twat","vittu","wank*","wetback*","wichser","wop*","yed","zabourah",);
        return $badwordsArray;
        
    }
    
    public function getGushyWordsArray()
    {
        $gushArray=array("heart","love","loving","lovers","hearts","hug","hugs",
            "hugging","kiss","kisses","tenderly","miss you","hurt","hurting",
            "honey","romantic","lovely","pretty","adore","adored","dearly",
            "exquisite","cherished","cherish","charming", "passion", "affection", 
            "tenderness", "sexy","emotion","devoted","radiant","marry","wife",
            "wifey","touch","cuddle","cuddles","flirt","thoughtful","warmhearted",
            "pleasure","elegance","affection","affectionate","charm","charming",
            "friend","friends","enchant","attracted","attraction","beautiful",
            "embrace","embracing","breathtaking","devoted","dreamy","tender",
            "tenderness","care","caring","beloved");
        return $gushArray;
    }
    
    
    public function getMaterialWordsArray()
    {
        $materialArray=array("swag","money","cars","car","diamonds","houses","house",
                        "crib","cribs","bling","dollars","cash","papers","Hermès",
                        "Chanel","Louis Vuitton","Christian Dior","Versace","Prada",
                        "Fendi","Armani","Rolls Royce","Bentley","Ferrari","Lamborghini",
                        "Maserati","Aston Martin","Bugatti","gold","gucci","chains","watches",
                        "jewels","cash","bills","private jet","first class","roller","ciroc","paper",
                        "cake","scroll", "boutique","ice","jags", "liquor","crystal","champagne");
        return $materialArray;        
    }
    
    
    public function getSexyWordsArray()
    {
        $sexyArray=array(
            "sex","sexing","lovemaking","fucking","porn","kiss","kissing","bend over","cock","dick","pussy","fuck me","titties","lips","ass","cum","dong","tongue","touching"
        );
        return $sexyArray;            
    }
    
    public function getWhinyWordsArray()
    {
        $whinyArray=array(
            "sad","cry","crying","lonely","tears","rain","cold","upset","tear drops","miss you","missing you","live without you","apart", "turn back time","sorry","wrong", "hurt"
        );
        return $whinyArray;            
    }    
    
}
?>
